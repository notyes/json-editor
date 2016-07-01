<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__.'/../inc.php';


if ( empty( $_GET['type'] ) ) {
    header('Location: '.ABSURL); 
}else if( ! in_array( $_GET['type'] , array( 'food', 'fair' ) ) ){
    header('Location: '.ABSURL); 
}

$file_save = __DIR__.'/../'.$_GET['type'].'.json';


if (!file_exists($file_save)) {
    $fh = fopen($file_save, 'a');
    fwrite($fh, "");
    fclose($fh);
    chmod($file_save, 0777);
}

$data = file_get_contents( $file_save ,FILE_USE_INCLUDE_PATH);

if (empty( $data )) {
    $data = '[{"name": "","style": "column","layout": "left","type": "radio","subs": [{"name": ""}]}]';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Date</title>
    
    <!-- Foundation CSS framework (Bootstrap and jQueryUI also supported) -->
    <link rel='stylesheet' href='//cdn.jsdelivr.net/foundation/5.0.2/css/foundation.min.css'>
    <!-- Font Awesome icons (Bootstrap, Foundation, and jQueryUI also supported) -->
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'>
    <script src="../dist/jquery-1.8.0.min.js"></script>
    <script src="../dist/jsoneditor.js"></script>
    <style type="text/css" media="screen">
        table {
          width: 100%;
        }
    </style>    
    <script>
    // Set the default CSS theme and icon library globally
    JSONEditor.defaults.theme = 'foundation5';
    JSONEditor.defaults.iconlib = 'fontawesome4';
    </script>
  </head>
  <body>
    <div class='row'>
      <div class='medium-12 columns'>
        <h3>ระบบใส่ข้อมูลหัวข้อและรายการตัวเลือก ใน ระบบลงทะเบียน <?php echo $_GET['type'] ?></h3>
      </div>
    </div>
    <div class='row'>
      <div class='medium-12-columns'>
        <button id='submit' class='tiny'>Submit (ส่งข้อมูล)</button>
        <button id='restore' class='secondary tiny'>Restore to Default</button>
        <span id='valid_indicator' class='label'></span>
      </div>
    </div>
    <div class='row'>
      <div id='editor_holder' class='medium-12 columns'></div>
    </div>
    
    <script>
      // This is the starting value for the editor
      // We will use this to seed the initial editor 
      // and to provide a "Restore to Default" button.
      var starting_value = <?php echo $data ?>;
      
      // Initialize the editor
      var editor = new JSONEditor(document.getElementById('editor_holder'),{
        // Enable fetching schemas via ajax
        ajax: true,
        
        // The schema for the editor
        schema: {
          $ref: "person_page.json",
          format: "grid"
        },
        
        // Seed the form with a starting value
        startval: starting_value
      });
      
      // Hook up the submit button to log to the console
      document.getElementById('submit').addEventListener('click',function() {
        // Get the value from the editor
        console.log(editor.getValue());

        $.post('<?php echo ABSURL ?>update.php?type=<?php echo $_GET['type'] ?>', {param: JSON.stringify(editor.getValue())}, function() {
          alert('Success to save data');
        });


      });

      // Hook up the Restore to Default button
      document.getElementById('restore').addEventListener('click',function() {
        editor.setValue(starting_value);
      });
      
      // Hook up the validation indicator to update its 
      // status whenever the editor changes
      editor.on('change',function() {
        // Get an array of errors from the validator
        var errors = editor.validate();
        
        var indicator = document.getElementById('valid_indicator');
        
        // Not valid
        if(errors.length) {
          indicator.className = 'label alert';
          indicator.textContent = 'not valid';
        }
        // Valid
        else {
          indicator.className = 'label success';
          indicator.textContent = 'valid';
        }
      });
    </script>
  </body>
</html>

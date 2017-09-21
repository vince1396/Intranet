<?php

    function input($type, $name){
        
        $html = "<div class=''>";
        $html = "<input type='form-group'>";
        $html = ""
        
        return $html; 
    }

    function submit($name, $value, $class = "btn-default"){
        
        $html = "<button type='submit' name='$name' class='btn $class'>$value</button>";
        
        return $html;
    }

    function textarea($name, $row = 3, $options = []){
        $html = "<textarea class='form-control' name='$name' id='$name' rows='$row'></textarea>";
        
        return $html;
    }

    function select($name, $values = []){
        $html = "<select class='form-control' name='$name' id='$name'>";
        foreach ($values as $value){
            $html .= "<option value='$value'>$value</option>";
        }
        $html .= "</select>";
        
        return $html;
    }

     function checkbox($label, $name){
        $html = "<div class='checkbox'>";
        $html .= "<label>";
         $html .= "<input name='$name' id='$name' type='checkbox'> $label";
        
        return $html;
    }

    function radio($label, $name, $values, $options = []){
       
       $constructor = '';
        foreach ($options as $k => $v)
        {
            $constructor .= "$k = '$v'";
        }
        
       $html = "<div class='radio'> $label";
        foreach ($values as $value){
            $html .= "<label>";
            $html .= "<input type='radio' $constructor name ='$name' id='$name' value='$value' checked>";
            $html .= $value;
            $html .= "</label>"
        }
        return $html;
    }

    function connexion(){
        try{
            
            return new PDO('mysql:host=localhost;dbname=intranet;charset-utf8')
            
        }
    }

?>
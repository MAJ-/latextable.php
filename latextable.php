<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Simple Latex-Table generator</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
    table { width:100%; }
    tr    { width:100%; }
    input { width:100%; }
    p     { margin:0px; }
</style>
</head>
<body>

<h1>A simple LaTeX-table generator</h1>

<p>This simple LaTeX-table generator allows you to create simple tables in LaTeX-Code. You just need to type the number of rows and columns to create a site, where you can type your table content. When you have submitted your table content, the LaTeX-Code appears. Notice: the table content in a cell is placed in the middle, it's centered, if you want to change it, change the table-formatting in \begin{tabular}{<b>format</b>} <b>Have Fun!</b><br /><br /></p>

<?php if(   !is_int(intval($_POST['rows']))
         || !is_int(intval($_POST['columns']))
         || !($_POST['rows'] > 0)
         || !($_POST['columns'] > 0)){
?>
<p><b>Please type the number of rows and columns:</b></p>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" accept-charset="utf-8">
    <p>Rows:<br /><input name="rows" type="text" /></p>
    <p>Columns:<br /><input name="columns" type="text" /></p>
    <p><input type="submit" value="submit" /></p>
</form>
<?php
      }else if(!isset($_POST['cell'])){
?>
<p><b>Please type the table content:</b></p>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" accept-charset="utf-8">
<table>
<?php
           for($i = 0; $i < $_POST['rows']; $i++){
               echo '        <tr>'."\n";
                   for($j = 0; $j < $_POST['columns'];$j++){
                       echo '            <td>'.'<p><input name="cell[]" type="text" /></p>'.'</td>'."\n";                        
                   }
               echo '        </tr>'."\n";
           }
?>
</table>
<p><input type="hidden" name="rows" value="<?php echo $_POST['rows']; ?>" /></p>
<p><input type="hidden" name="columns" value="<?php echo $_POST['columns']; ?>" /></p>
<p><input type="submit" value="submit" /></p>
</form>
<?php
       }else {
            $x = $_POST['rows']*$_POST['columns'];
            //fill not-initiated variables with the space-character
            for($i = 0; $i < $x; $i++){
                if(!isset($_POST['cell'][$i])){
                    $_POST['cell'][$i] = ' ';
                }
                $_POST['cell'][$i] = str_replace("&","\&",$_POST['cell'][$i]);
                $_POST['cell'][$i] = htmlspecialchars($_POST['cell'][$i]);
            }
            echo "<p>Here's the LaTeX-Code, just copy and paste it to your LaTeX-file:</p>"."\n";
            echo "<pre>";
            echo '\begin{tabular}{|';
            for($i=0;$i < $_POST['columns'];$i++)
                echo 'c|';
            echo '}';
            echo "\n".'\hline';

            for($z = 0;$z < $x;$z++){
                for($i=1;$i<$_POST['rows'];$i++){
                    echo "\n".$_POST['cell'][$z];
                    for($j=1;$j<$_POST['columns'];$j++){
                        echo ' &amp; '.$_POST['cell'][++$z];
                    }
                echo ' \\\\';
                echo "\n".'\hline';
                }
            }
            echo "\n".'\end{tabular}';
            echo "</pre>";
        }
?>

<h2>Features:</h2>

<ul>
<li>Anti-XSS measures</li>
<li>&amp; replaced by \&amp; (LaTeX-compatible)</li>
</ul>
<p>
  <br />
    <a href="http://validator.w3.org/check?uri=referer">
    <img src="http://www.w3.org/Icons/valid-xhtml10"
         alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
  </p>

</body>
</html>

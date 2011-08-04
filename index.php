<?
include_once("index_top.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>Main courante</title>
</head>
<body>
    <h1>Main courante</h1>
    <form name="frm_login" action="index.php" method="POST" enctype="application/x-www-form-urlencoded">
    <table>
        <tr>
            <td>
                Login :
            </td>
            <td>
                <input type="text" id="txt_login" name="txt_login" size="20" maxlength="20" />
            </td>
        </tr>
        <tr>
            <td>
                Mot de passe :
            </td>
            <td>
                <input type="password" id="txt_password" name="txt_password" size="20" maxlength="20" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="reset">Reset</button> <button type="submit">Soumettre</button>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
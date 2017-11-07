<?php
class mail_form
{
    function dataFilter($data)
    {
        $data = strip_tags($data);
        $data = trim(htmlentities($data, ENT_QUOTES, "UTF-8"));
        if(get_magic_quotes_gpc())
        {
            $data= stripslashes($data);

        }
        return $data;
    }

    function requireCheck($requireValue)
    {
        $res['errm'] = '';
        $res['empty_flag'] = 0;

        foreach($requireValue as $key_r => $value)
        {
            $existFlag = '';
            foreach ($_POST as $key => $val)
            {
                if($key == $key_r && empty($val))
                {
                    $res["errm"] .= "<p class =\"error_message\"> Please enter into ". $value;
                    $res["empty_flag"] = 1;
                    $existFlag = 1;
                    break;
                }
                elseif($key_r  == $key)
                {
                    $existFlag = 1;
                    break;
                }
            }
            if($existFlag != 1)
            {
                $res["errm"] .= "<p class =\"error_message\"> Please enter into ". $key_r;
                $res["empty_flag"] = 1;
            }
        }
        return $res;
    }
}

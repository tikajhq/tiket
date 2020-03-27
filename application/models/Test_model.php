<?PHP

//All testings can be done here
class Test_model
{

    public function test($name)
    {
        $res = "Hello " . $name;
        log_message('error', "test");
        return $res;
    }
}
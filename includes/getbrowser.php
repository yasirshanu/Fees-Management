<?php
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    function getOS()
    {
        global $user_agent;
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile',
            '/OpenBSD/i'            =>  'Openbsd',
            '/SunOS/i'              =>  'Sunos',
            '/QNX/i'                =>  'QNX',
            '/BeOS/i'               =>  'Beos',
            '/OS2/i'                =>  'OS/2',
            '/SearchBot/i'          =>  'Bot'
        );
        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;
        return $os_platform;
    }
    function getBrowser()
    {
        global $user_agent;
        $browser = "Unknown Browser";
        $browser_array = array(
            '/safari/i'         => 'Safari',
            '/msie/i'           => 'Internet Explorer',
            '/trident/i'        => 'Internet Explorer',
            '/firefox/i'        => 'Firefox',
            '/edge/i'           => 'Edge',
            '/opera/i'          => 'Opera',
            '/netscape/i'       => 'Netscape',
            '/maxthon/i'        => 'Maxthon',
            '/konqueror/i'      => 'Konqueror',
            '/mobile/i'         => 'Handheld Browser',
            '/chrome/i'         => 'Google Chrome',
        );
        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;
        return $browser;
    }
    /* detect mobile device*/
    function getDevice()
    {
        global $user_agent;
        $device = "Unknown Device";
        $device_array = array(
            '/Blazer/'                   => 'Blazer',
            '/Palm/'                     => 'Palm',
            '/Handspring/'               => 'Handspring',
            '/Nokia/'                    => 'Nokia',
            '/Kyocera/'                  => 'Kyocera',
            '/Samsung/'                  => 'Samsung',
            '/Motorola/'                 => 'Motorola',
            '/Smartphone/'               => 'Smartphone',
            '/Windows CE/'               => 'Windows OS',
            '/Blackberry/'               => 'Blackberry',
            '/WAP/'                      => 'WAP',
            '/SonyEricsson/'             => 'Sony Ericsson',
            '/PlayStation Portable/'     => 'Playstation Portable',
            '/LG/'                       => 'LG',
            '/MMP/'                      => 'MMP',
            '/OPWV/'                     => 'OPWV',
            '/Symbian/'                  => 'Symbian',
            '/EPOC/'                     => 'EPOC',
            '/ASUS/'                     => 'ASUS',
            '/CPH/'                      => 'Oppo',
            '/Vivo/'                     => 'Vivo',
            '/vivo/'                     => 'Vivo',
            '/iPhone/'                   => 'iPhone',
            '/HTC/'                      => 'HTC',
        );
        foreach($device_array as $regex => $value)
            if(preg_match($regex, $user_agent))
                $device = $value;
        return $device;
    }
    $user_os = getOS();
    $user_browser = getBrowser();
    $user_device = getDevice();
    $server_name = gethostname();
?>
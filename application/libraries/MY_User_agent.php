<?php

class MY_User_agent extends CI_User_agent
{
public $is_tablet = FALSE;
public $tablets = array();

public function __construct()
{
    parent::__construct();
}

// --------------------------------------------------------------------

/**
 * Compile the User Agent Data
 *
 * @return  bool
 */
protected function _load_agent_file()
{
    $return = parent::_load_agent_file();

    if (($found = file_exists(APPPATH.'config/user_agents.php')))
    {
        include(APPPATH.'config/user_agents.php');
    }

    if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php'))
    {
        include(APPPATH.'config/'.ENVIRONMENT.'/user_agents.php');
        $found = TRUE;
    }

    if ($found !== TRUE)
    {
        return FALSE;
    }

    if (isset($tablets))
    {
        $this->tablets = $tablets;
        unset($tablets);
        $return = TRUE;
    }

    return $return;
}

// --------------------------------------------------------------------

/**
 * Is Tablet
 *
 * @param   string  $key
 * @return  bool
 */
public function is_tablet($key = NULL)
{
    if ( ! $this->is_tablet)
    {
        return FALSE;
    }

    // No need to be specific, it's a tablet
    if ($key === NULL)
    {
        return TRUE;
    }

    // Check for a specific tablet
    return (isset($this->tablets[$key]) && $this->tablet === $this->tablets[$key]);
}

// Returns whether the agent is known to have a large screen (greather than or equal to 640 (virtual) pixels wide)
public function has_large_screen()
{
    return ! $this->is_mobile(); // mobile includes tablets
}

// Returns whether the agent is known to have a small screen (less than 640 (virtual) pixels wide)
public function has_small_screen()
{
    return $this->is_mobile && ! $this->is_tablet;
}

// --------------------------------------------------------------------

/**
 * Parse a custom user-agent string
 *
 * @param   string  $string
 * @return  void
 */
public function parse($string)
{
    $this->is_tablet = FALSE;
    $this->tablet = '';

    parent::parse($string);
}

// --------------------------------------------------------------------

/**
 * Compile the User Agent Data
 *
 * @return  bool
 */
protected function _compile_data()
{
    $this->_set_platform();

    foreach (array('_set_robot', '_set_browser', '_set_mobile', '_set_tablet') as $function)
    {
        if ($this->$function() === TRUE)
            break;
    }
}

// --------------------------------------------------------------------

/**
 * Set the Mobile Device
 *
 * @return  bool
 */
protected function _set_mobile()
{
    if ($retval = parent::_set_mobile())
        $this->_set_tablet();

    return $retval;
}

// --------------------------------------------------------------------

/**
 * Set the Tablet Device
 *
 * @return  bool
 */
protected function _set_tablet()
{
    if (is_array($this->tablets) && count($this->tablets) > 0)
    {
        foreach ($this->tablets as $key => $val)
        {
            if (FALSE !== (stripos($this->agent, $key)))
            {
                if ($val == 'Android' && FALSE !== strpos($this->agent, 'Mobile'))
                    continue;

                $this->is_tablet = TRUE;
                $this->tablet = $val;
                return TRUE;
            }
        }
    }

    return FALSE;
}
}
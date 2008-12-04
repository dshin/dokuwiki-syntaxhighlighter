<?php
/**
 * SyntaxHighlighter plugin
 * 
 * @license    LGPL 2 (http://www.gnu.org/licenses/lgpl.html)
 * @author     David Shin <dshin@pimpsmart.com>
 */
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
 
class action_plugin_syntaxhighlighter extends DokuWiki_Action_Plugin {
 
  /**
   * return some info
   */
  function getInfo(){
    return array(
                 'author' => 'David Shin',
                 'email'  => 'dshin@pimpsmart.com',
                 'date'   => '2008-12-04',
                 'name'   => '<code> tag replacement',
                 'desc'   => 'Replaces GeSHi server-side code highlighting with client-side SyntaxHightlighter 1.5.1 by Alex Gorbatchev. SyntaxHighlighter can be found at http://code.google.com/p/syntaxhighlighter/.',
                 'url'    => 'http://wiki.splitbrain.org/plugin:syntaxhighlighter',
                 );
  }
    
  /*
   * plugin should use this method to register its handlers with the dokuwiki's event controller
   */
  function register(&$controller) {
    $controller->register_hook('TPL_METAHEADER_OUTPUT',
                               'BEFORE',
                               $this,
                               '_hooksh');
  }

  /**
   *  Inject the SyntaxHightlighter files
   *
   *  @author David Shin <dshin@pimpsmart.com>
   *  @param $event object target event
   *  @param $param mixed event parameters passed from register_hook
   *
   *  To add other languages, add additional events to this function
   */
  function _hooksh (&$event, $param) {      
      $event->data['link'][] = array( 'rel'=>'stylesheet'
                                     ,'type'=>'text/css'
                                     ,'title'=>'SyntaxHighlighter styles'
                                     ,'href'=>DOKU_BASE.'lib/plugins/syntaxhighlighter/Styles/SyntaxHighlighter.css'
                                     ,'_data'=>'');
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shCore.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushCpp.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushCSharp.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushCss.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushDelphi.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushJava.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushPhp.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushPython.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushRuby.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushSql.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushVb.js"
				          );
      $event->data["script"][] = array ("type" => "text/javascript",
	  "src" => DOKU_BASE."lib/plugins/syntaxhighlighter/Uncompressed/shBrushXml.js"
				          );
  }
}

<?php
/**
 * Code Plugin: replaces Dokuwiki's own code syntax with SyntaxHighigter by Alex Gorbatchev.
 *              This plugin is based off of SyntaxHighlighter 1.5.1 which can be found at
 *              http://code.google.com/p/syntaxhighlighter/
 *
 * Syntax:     <code lang:nogutter:nocontrols:collapse:firstline[value]:showcolumns>
 *   lang        (optional) programming language name that will be passed to syntaxhighlighter.
 *               If not provided, the plugin will use the default syntax highlighting.
 *               Refer to http://code.google.com/p/syntaxhighlighter/wiki/Languages for list of supported languages.
 *               For more languages, please add the .js files contributed by other users.
 *   nogutter    (optional) will display no gutter.
 *   nocontrols  (optional) will display no controls at the top
 *   collapse    (optional) will collapse the block by default
 *   firstline[value] (optional) will begin line count at value.  Default value is 1.
 *   showcolumns (optional) will show row columns in the first line.
 *
 * The options are passed together with the alias and are separated by a colon : character. e.g
 * <pre name="code" class="html:nocontrols:firstline[10]">
 * ... some code here ...
 * </pre>
 * 
 * @license    LGPL 2 (http://www.gnu.org/licenses/lgpl.html)
 * @author     David Shin <dshin@pimpsmart.com>  
 */
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_syntaxhighlighter_code extends DokuWiki_Syntax_Plugin {
 
    var $syntax = "";
 
    /**
     * return some info
     */
    function getInfo(){
      return array(
        'author' => 'David Shin',
        'email'  => 'dshin@pimpsmart.com',
        'date'   => '2008-12-04',
        'name'   => 'SyntaxHighlighter Plugin',
        'desc'   => 'Replacement for Dokuwiki\'s own <code> handler with SyntaxHighigter by Alex Gorbatchev.
                     Syntax: <code lang:nogutter:nocontrols:collapse:firstline[value]:showcolumns>, all configurations are optional.',
        'url'    => 'http://wiki.splitbrain.org/plugin:syntaxhighlighter',
      );
    }
 
    function getType(){ return 'protected';}
    function getSort(){ return 195; }
    function getPType(){ return 'block'; }
 
    /**
     * Connect pattern to lexer
     */
    function connectTo($mode) {       
      $this->Lexer->addEntryPattern('<code(?=[^\r\n]*?>.*?</code>)',$mode,'plugin_syntaxhighlighter_code');
    }
 
    function postConnect() {
      $this->Lexer->addExitPattern('</code>', 'plugin_syntaxhighlighter_code');
    }
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, &$handler){
 
        switch ($state) {
            case DOKU_LEXER_ENTER:
                $this->syntax = substr($match, 1);
                return false;
 
            case DOKU_LEXER_UNMATCHED:
                // will include everything from <code ... to ... </code >
                // e.g. ... [lang]:nogutter:nocontrols:collapse:firstline[value]:showcolumns> [content]
                list($attr, $content) = preg_split('/>/u',$match,2);
 
                if ($this->syntax == 'code') {
                    $attr = trim($attr);
                    if ($attr == NULL) {
                        $attr = 'html';
                    }
                } else {
                    $attr = NULL;
                }
 
                return array($this->syntax, $attr, $content);
        }       
        return false;
    }

    /**
     * Create output
     */
    function render($mode, &$renderer, $data) {
 
      if($mode == 'xhtml'){
        if (count($data) == 3) {
 
            list($syntax, $attr, $content) = $data;
            if ($syntax == 'code') 
                $renderer->doc .= "<pre name=\"code\" class=\"".$attr."\">".$renderer->_xmlEntities($content)."</pre>";
            else 
                $renderer->file($content);
        }
        return true;
      }
      return false;
    }
}


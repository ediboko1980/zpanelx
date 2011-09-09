<?php

/**
 * @package zpanelx
 * @subpackage dryden -> ui
 * @author Bobby Allen (ballen@zpanelcp.com)
 * @copyright ZPanel Project (http://www.zpanelcp.com/)
 * @link http://www.zpanelcp.com/
 * @license GPL (http://www.gnu.org/licenses/gpl.html)
 */
class ui_templateparser {

    /**
     * Loads in the template content and parses it to compute the place holder content.
     * @param string $template_path The full path to the system template (or user template)
     * @return sting 
     */
    static function Generate($template_path) {
        $template_raw = file_get_contents($template_path . "/master.ztml");
        $template_html = ui_templateparser::Process($template_raw);
        return eval('?>' . $template_html);
    }

    /**
     * Replaces the template place holders with the equivilent dynamic infomation.
     * @param string $raw
     * @return string 
     */
    static function Process($raw) {
        /**
         * @todo Add dynamic place holders which relate to class methods (for easy extending) - All place holders will be placed in an XML file.
         * for now the below is just a test!
         */
        $tplp = new runtime_dataobject;
        $tplp->addItemValue('assetfolderpath', 'etc/styles/zpanel6/');
        $tplp->addItemValue('version_apache', sys_versions::ShowApacheVersion());
        $tplp->addItemValue('version_php', sys_versions::ShowPHPVersion());
        #$tplp->addItemValue('version_mysql', sys_versions::ShowMySQLVersion());
        $tplp->addItemValue('version_platform', sys_versions::ShowOSPlatformVersion());
        $tplp->addItemValue('version_kernal', sys_versions::ShowOSKernalVersion(''));

        /*
         * Add PHP execution protection!
         */
        $tplp->addItemValue('<?', "<<");
        $tplp->addItemValue('?>', ">>");

        foreach ($tplp->getDataObject() as $placeholder => $replace) {
            $raw = str_replace("<% " . $placeholder . " %>", $replace, $raw);
        }
        return $raw;
    }

}

?>

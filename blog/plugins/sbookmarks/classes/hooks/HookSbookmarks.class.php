<?php 
class PluginSbookmarks_HookSbookmarks extends Hook {  
	public function RegisterHook() {	
		$this->AddHook('template_html_head_end', 'tplHeader', __CLASS__, 2);
		$this->AddHook('template_topic_show_end', 'tplTopic', __CLASS__, -5);    
	}

	public function tplHeader($aVars) {
		return $this->Viewer_Fetch(Plugin::GetTemplatePath('sbookmarks').'/inject.header.tpl');
	} 
	
	public function tplTopic($aVars) {
		$this->Viewer_Assign('oTopic',$aVars['topic']);
		return $this->Viewer_Fetch(Plugin::GetTemplatePath('sbookmarks').'/inject.topic.tpl');
	} 
}
?>
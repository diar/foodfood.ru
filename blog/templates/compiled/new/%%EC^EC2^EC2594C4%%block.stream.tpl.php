<?php /* Smarty version 2.6.19, created on 2010-05-26 20:32:26
         compiled from block.stream.tpl */ ?>
			<div class="block stream">

				<div class="tl"><div class="tr"></div></div>
				<div class="cl"><div class="cr">
					
					<h1><?php echo $this->_tpl_vars['aLang']['block_stream']; ?>
</h1>
					
					<ul class="block-nav">						
						<li><strong></strong><a href="#" id="block_stream_topic" onclick="lsBlockStream.toggle(this,'topic_stream'); return false;"><?php echo $this->_tpl_vars['aLang']['block_stream_topics']; ?>
</a></li>
						<li class="active"><a href="#" id="block_stream_comment" onclick="lsBlockStream.toggle(this,'comment_stream'); return false;"><?php echo $this->_tpl_vars['aLang']['block_stream_comments']; ?>
</a><em></em></li>
					</ul>					
					
				<div class="block-content">
					<?php echo '
						<script language="JavaScript" type="text/javascript">
						var lsBlockStream;
						window.addEvent(\'domready\', function() { 
							lsBlockStream=new lsBlockLoaderClass();
						});
						</script>
					'; ?>
					
					
					<?php echo $this->_tpl_vars['sStreamComments']; ?>


					</div>
				</div></div>
				<div class="bl"><div class="br"></div></div>
			</div>

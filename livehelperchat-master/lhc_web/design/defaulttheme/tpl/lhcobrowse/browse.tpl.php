<div id="chrome" >
<div class="container-fluid">
	<div class="row co-browse-toolbar">
		<div class="col-xs-6">		
			<div class="row">       
	          <div class="col-xs-9">
	           <input class="form-control" id="awesomebar" name="url" value="<?php echo htmlspecialchars($browse->url)?>" type="text">
	          </div>
	          <div class="col-xs-3">
	            	<a href="#" class="btn btn-primary btn-xs col-xs-12" onclick="return lhinst.addRemoteCommand('<?php echo $chat->id?>','lhc_cobrowse:<?php echo $browse->chat_id?>_<?php echo $browse->chat->hash?>')"><i title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','Request screen share')?>" class="material-icons">visibility</i></a>
	          </div>
	        </div>
		</div>
		<div class="col-xs-6 columns">
			<label class="pull-left" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','Show my mouse position to visitor')?>"><input type="checkbox" value="on" id="show-operator-mouse" ><i class="material-icons">mouse</i></label> <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','On highlight scroll user window location to match my')?>" class="pull-left"><input id="scroll-user-window" value="on" type="checkbox"><i class="material-icons">navigation</i></label> <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','Follow user scroll position')?>" class="pull-left"><input id="sync-user-scroll" value="on" type="checkbox"><i class="material-icons">gamepad</i></label> <label title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('cobrowse/browse','On click navigate user browser')?>" class="pull-left"><input id="status-icon-control" value="on" type="checkbox"><i class="material-icons">keyboard</i></label>
			<?php if (erLhcoreClassUser::instance()->hasAccessTo('lhchat','allowredirect')) : ?>
			<a class="material-icons pull-left" onclick="lhinst.redirectToURL('<?php echo $chat->id?>','<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','Please enter a URL');?>')" title="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','Redirect user to another url');?>">link</a>
			<?php endif;?>
			
			<i title="" id="status-icon-sharing" class="pull-left material-icons"><?php echo $browse->is_sharing == 0 ? 'visibility_off' : 'visibility'?></i>
			<label id="last-message" class="pull-right"><?php echo $browse->mtime > 0 && $browse->initialize != '' ? $browse->mtime_front : '' ?></label>
		</div>
	</div>	
</div>	
</div>

<div id="contentWrap">
<div class="container-fluid h100proc">
<div class="row h100proc">
    <div class="col-xs-3 pr-0 h100proc" id="cobrose-chat-window">
        <?php $chat_id = $chat->id;$chat_to_load = $chat;?>
        <?php include(erLhcoreClassDesign::designtpl('lhchat/single.tpl.php')); ?>        
    </div>
    <div class="columns col-xs-9 h100proc">        
        	<div id="center-layout">
                <iframe id="content" name="content" src="<?php echo erLhcoreClassDesign::baseurl('cobrowse/mirror')?>" frameborder="0"></iframe>
            </div>       
    </div>
</div>
</div>


</div>


<script>
<?php include(erLhcoreClassDesign::designtpl('lhcobrowse/operatorinit.tpl.php')); ?>
</script>
<h1 class="cu-section-title"><?php _e('Available Themes', 'xthemes'); ?></h1>
<div class="cu-box">

    <div class="box-content">
        <div class="xt_current">
            <?php if($current): ?>
                <div class="xt_current_screenshot">
                    <img src="<?php echo $current->url().'/'.$current->getInfo('screenshot'); ?>" alt="<?php echo $current->getInfo('name'); ?>" />
                </div>
                <div class="xt_current_data">
                    <span class="current_legend"><?php _e('Current Theme','xthemes'); ?></span>
                    <h2><?php echo $current->getInfo('name'); ?></h2>
                    <?php if($current->getInfo('type')=='standard'): ?>
                        <div class="current_standar_legend">
                            <?php _e('This is a standard XOOPS Theme and doesn\'t have any additional option.','xthemes'); ?>
                        </div>
                        <a href="<?php echo XOOPS_URL; ?>" class="button" target="_blank"><i class="icon-home"></i> <?php _e('View Site','xthemes'); ?></a>
                    <?php else: ?>
                        <div class="current_data">
                            <ul>
                                <li>
                                    <?php if($current->getInfo('author_uri')!=''): ?>
                                        <?php echo sprintf(__('By %s', 'xthemes'), '<a href="'.$current->getInfo('author_uri').'" target="_blank">'.$current->getInfo('author').'</a>'); ?>
                                    <?php else: ?>
                                        <?php echo sprintf(__('By %s','xthemes'), $current->getInfo('author')); ?>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <?php echo sprintf(__('Version %s','xthemes'), $current->getInfo('version')); ?>
                                </li>
                                <?php if($current->getInfo('uri')!=''): ?>
                                    <li><a href="<?php echo $current->getInfo('uri'); ?>" target="_blank"><?php _e('Website','xthemes'); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="current_description">
                            <p><?php echo $current->getInfo('description'); ?></p>
                        </div>
                        <div class="current_options">
                            <h4><span><?php _e('Theme Options','xthemes'); ?></span></h4>
                            <?php if(method_exists($current, 'controlPanel')): ?>
                                <a href="theme.php" class="btn btn-default"><i class="icon-gear"></i> <?php _e('Dashboard','xthemes'); ?></a>
                            <?php endif; ?>
                            <?php if($xtAssembler->rootMenus()): ?>
                                <a href="navigation.php" class="btn btn-default"><i class="fa fa-th-list"></i> <?php _e('Menus','xthemes'); ?></a>
                            <?php endif; ?>
                            <?php if($current->settings()): ?>
                                <a href="settings.php" class="btn btn-default"><i class="fa fa-wrench"></i> <?php _e('Settings','xthemes'); ?></a>
                            <?php endif; ?>
                            <?php if($current->getInfo('uri')!=''): ?>
                                <a href="<?php echo $current->getInfo('uri'); ?>" target="_blank" class="btn btn-default"><i class="fa fa-home"></i> <?php _e('Website','xthemes'); ?></a>
                            <?php endif; ?>
                            <?php if($current->getInfo('author_uri')!=''): ?>
                                <a href="<?php echo $current->getInfo('author_uri'); ?>" target="_blank" class="btn btn-default"><i class="fa fa-user"></i> <?php _e('Author','xthemes'); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<div class="xt_available">
    <h4>Other available themes</h4>
    <?php foreach($themes as $theme): ?>
    <?php if($theme['dir'] != $current->getInfo('dir')): ?>
    <div class="available_theme" id="available-<?php echo $theme['dir']; ?>">
        <div class="theme_screenshot">
            <img class="thumbnail" src="<?php echo $theme['url'].'/'.$theme['screenshot']; ?>" alt="<?php echo $theme['name']; ?>">
        </div>
        <div class="available_details">
            <h6><?php echo $theme['name']; ?></h6>
            <?php if(isset($theme['type']) && $theme['type']=='standard'): ?>
            <span class="help-block"><?php echo _e('This is a standard XOOPS theme.','xthemes'); ?></span>
            <div class="theme_options">
                <ul>
                    <li><a href="themes.php?action=activate&amp;dir=<?php echo $theme['dir']; ?>&amp;token=<?php echo $xoopsSecurity->createToken(); ?>"><?php _e('Activate','xthemes'); ?></a></li>
                    <li><a href="#" class="theme_apreview" id="preview-<?php echo $theme['dir']; ?>"><?php _e('Preview','xthemes'); ?></a></li>
                </ul>
            </div>
            <?php else: ?>
            <div class="theme_author">
                <?php echo sprintf(__('By %s','xthemes'), '<a href="'.$theme['author_uri'].'" target="_blank">'.$theme['author'].'</a>'); ?>
            </div>
            <div class="theme_options">
                <ul>
                    <?php if(!$theme['installed']): ?>
                    <li><a href="themes.php?action=install&amp;dir=<?php echo $theme['dir']; ?>&amp;token=<?php echo $xoopsSecurity->createToken(); ?>"><?php _e('Install','xthemes'); ?></a></li>
                    <?php else: ?>
                    <li><a href="themes.php?action=activate&amp;dir=<?php echo $theme['dir']; ?>"><?php _e('Activate','xthemes'); ?></a></li>
                    <li><a href="themes.php?action=uninstall&amp;dir=<?php echo $theme['dir']; ?>"><?php _e('Uninstall','xthemes'); ?></a></li>
                    <?php endif; ?>
                    <li><a href="#" class="theme_apreview" id="preview-<?php echo $theme['dir']; ?>"><?php _e('Preview','xthemes'); ?></a></li>
                    <li><a href="#" class="theme_adetails"><?php _e('Details','xthemes'); ?></a></li>
                </ul>
            </div>
            <div class="theme_details" id="details-<?php echo $theme['dir']; ?>">
                <span class="theme_description">
                    <?php echo $theme['description']; ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
<div id="xt-previewer-blocker"></div>
<div id="xt-previewer">
    <div class="title"><span></span><span class="close">&times;</span></div>
    <div class="website"></div>
</div>


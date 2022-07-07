<?php
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headView.php";
include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/headerView.php";
?>
<div id="__tagembed__widgetab" class="__tagembed__tabcontent">
    <div class="__tagembed__widgetarea">
        <div class="__tagembed__widgetactions">
            <div><h3>My Widget</h3></div>
            <div style="display:<?= (empty($__tagembed__widgets)) ? 'none' : ''; ?>">
                <a class="__tagembed__btn" href="javascript:void(0);" id="__tagembed__widget_create_form">Create</a>
            </div>
        </div>
        <div class="__tagembed__widgetinn" >
            <?php
            if (!empty($__tagembed__widgets)):
                $count = 0;
                foreach ($__tagembed__widgets as $__tagembed__widget):
                    ?>
                    <div class="__tagembed__widgetbox <?= $__tagembed__active_widget_id == $__tagembed__widget->id ? 'active' : ''; ?>" id="__tagembed__widgetbox<?= $count; ?>">
                        <div class="__tagembed__widgethead">
                            <div>
                                <h3><?= $__tagembed__widget->name; ?></h3>
                                <ul>
                                    <li><?= $__tagembed__widget->feedCount; ?>  Feeds</li>
                                    <li><?= $__tagembed__widget->networkCount; ?> Networks</li>
                                </ul>
                            </div>
                            <div class="tooltip">
                                <div class="__tagembed__toggleOnBut __tagembed__switch">
                                    <div class="__tagembed__onoffswitch">
                                        <input data-widgetStatus="<?= $__tagembed__widget->status; ?>" onchange="__tagembed__updateWidgetStauts('<?= $__tagembed__widget->id; ?>', '<?= $count; ?>');" type="checkbox" name="widget-<?= $count; ?>" id="widget-<?= $count; ?>" class="__tagembed__onoffswitch-checkbox __tagembed__updateStatus" data-on-color="#009385" data-off-color="#989898" <?= ($__tagembed__widget->status) ? 'checked' : ''; ?>>
                                        <label class="__tagembed__onoffswitch-label" for="widget-<?= $count; ?>">
                                            <span class="__tagembed__onoffswitch-inner"></span>
                                            <span class="__tagembed__onoffswitch-switch" style="background: rgb(152, 152, 152);"></span>
                                        </label>
                                    </div>
                                </div>
                                <span class="tooltiptext">Status</span>
                            </div>
                        </div>
                        <div class="__tagembed__widget_sourcecode">
                            <p>[tagembed widgetid <?= $__tagembed__widget->id; ?>]</p>
                            <button onclick="__tagembed__copyToWidgetShortCode('[tagembed widgetid <?= $__tagembed__widget->id; ?>]');" title="Copy Short Code"><i class="fa fa-files-o" aria-hidden="true"></i></button>
                        </div>
                        <div class="__tagembed__widgetfoot">
                            <ul>
                                <li><a href="javascript:void(0);" onclick="__tagembed__menus(2, '<?= $__tagembed__widget->id; ?>')"> Open </a></li>
                                <li><a href="javascript:void(0);" onclick="__tagembed__widgetEditForm('<?= $__tagembed__widget->id; ?>', '<?= $__tagembed__widget->name; ?>');"> Rename </a></li>
                                <li><a href="javascript:void(0);" onclick="__tagembed__deleteWidget('<?= $__tagembed__widget->id; ?>', '__tagembed__widgetbox<?= $count; ?>');"> Delete </a></li >
                            </ul>
                        </div>
                    </div>
                    <?php
                    $count++;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>
<?php include_once TAGEMBED_PLUGIN_DIR_PATH . "views/includes/footerView.php"; ?>
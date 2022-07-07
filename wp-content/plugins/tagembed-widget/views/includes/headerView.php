<div class="__tagembed__tabing">
    <div class="__tagembed__tabingone">
        <div class="__tagembed__menumob">
            <ul><li><span>Menu</span><a href="javascript:void(0)" id="__tagembed__burger" onclick="__tagembed__manageMenueHideShowInMobile();"><i class="fa fa-bars" aria-hidden="true"></i></a></li></ul></div>
        <ul class="__tagembed__mainmenu" id="__tagembed__menulist">
            <?php
            foreach ($__tagembed__menus as $__tagembed__menu):
                if ($__tagembed__menu->status):
                    $__tagembed__active_menue_id = $__tagembed__menu->id;
                endif;
                ?>
                <li onclick="__tagembed__menus('<?= $__tagembed__menu->id; ?>')" class="__tagembed__tablinks <?= $__tagembed__menu->status == 1 ? '__tagembed__active' : ''; ?>"><?= $__tagembed__menu->name; ?></li>
            <?php endforeach; ?>
        </ul>
        <ul class="__tagembed__branding">
            <li><a href="https://tagembed.com/" target="_blank"><img src="https://cdn.tagembed.com/website/assets/media/logos/logo.svg" alt="tagembed" /></a></li>
        </ul>
    </div>
    <div class="__tagembed__tabingtwo">
        <div class="__tagembed__tabtwoleft">
            <div class="__tagembed__selectwid">
                <?php if (!empty($__tagembed__widgets)): ?>
                    <?php if (!in_array($__tagembed__active_menue_id, [1, 5, 7, 8, 9])): ?>
                        <span class="<?= in_array($__tagembed__active_menue_id, [2]) ? "add-select-widget" : ""; ?> ">Selected Widget</sub></span>
                        <select name="__tagembed__widgets" id="__tagembed__widgets">
                            <?php foreach ($__tagembed__widgets as $__tagembed__widget): ?>
                                <option <?= $__tagembed__active_widget_id == $__tagembed__widget->id ? 'selected' : ''; ?> value="<?= $__tagembed__widget->id; ?>#<?= $__tagembed__widget->name; ?>" ><?= $__tagembed__widget->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                <?php else: ?>
                    <b>NOTE :</b> Create at least one widget <a class="__tagembed__btn" href="javascript:void(0);" id="__tagembed__widget_create_form">Create</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="__tagembed__tabtworight">
            <div class="__tagembed__msg">
                <script type="text/javascript">
                    function __tagembed__greatingMsg() {
                        var currentTime = new Date();
                        var hours = currentTime.getHours();
                        var minutes = currentTime.getMinutes();
                        var name = '<?= $__tagembed__active_widget_user_name; ?>';
                        if (hours >= 23) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/night.png"/><b>Hi,</b>' + name + ', It\'s almost midnight...Aren\'t you sleepy yet?');
                        } else if (hours >= 1 && hours <= 4) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/night.png"/><b>Hi,</b>' + name + ', Good morning! ' + hours + 'AM and still your going!');
                        } else if (hours >= 4 && hours <= 6) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/evening.png"/><b>Hi,</b>' + name + ', Good morning! , isn\'t it too early to be using your computer.');
                        } else if (hours >= 6 && hours <= 12) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/morning.png"/><b>Hi,</b>' + name + ', Good morning! , have a nice day!');
                        } else if (hours >= 12 && hours <= 14) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/noon.png"/><b>Hi,</b>' + name + ', NOON! Great, Have you eaten lunch yet??');
                        } else if (hours >= 14 && hours <= 17) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/noon.png"/><b>Hi,</b>' + name + ', Good Afternoon!');
                        } else if (hours >= 17 && hours <= 24) {
                            document.write('<img src="https://cdn.tagembed.com/wp-plugin/images/evening.png"/><b>Hi,</b>' + name + ', Good Evening! Welcome to prime time on the web!');
                        }
                    }
                    __tagembed__greatingMsg();
                </script>
            </div>
            <a href="javascript:void(0);" id="__tagembed__logout" class="__tagembed__logout"> Sign Out <img src="https://cdn.tagembed.com/wp-plugin/images/turn-off.png" alt="Sign Out" /></a>
        </div>
    </div>
</div>

<!--Start-- Manage Tagembed Loader How OR Not -->
<script>
    var __tagembed__loader_status = <?= in_array($__tagembed__active_menue_id, [5]) ? 0 : 1; ?>;
</script>
<!--End-- Manage Tagembed Loader How OR Not -->

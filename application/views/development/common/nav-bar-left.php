<?php

if (is_logged_in()) {
} else {
	redirect(base_url(), 'refresh');
	exit();
}
$nav_items = $this->common_model->get_all_navs();
?>

<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<?php
				foreach ($nav_items as $nav) {
					if ($nav['url']) {
						echo '<li><a href="' . base_url($nav["url"]) . '" class="';
						echo ($main_menu_name == $nav["main_menu_name"]) ? "active" : "";
						echo '">' . $nav["display_name"] . '</a></li>';
					} else {
						$li = '';
						$li .= '<li>';

						if ($main_menu_name == $nav["main_menu_name"]) {
							$li .= '<a href="#subPages_'.$nav["main_menu_name"].'" data-toggle="collapse" class="active">'.$nav["display_name"].'<i class="icon-submenu lnr lnr-chevron-left"></i></a>';
							$li .= '<div id="subPages_'.$nav["main_menu_name"].'" class="collapse in">';
						} else {
							$li .= '<a href="#subPages_'.$nav["main_menu_name"].'" data-toggle="collapse" class="collapsed">'.$nav["display_name"].'<i class="icon-submenu lnr lnr-chevron-left"></i></a>';
							$li .= '<div id="subPages_'.$nav["main_menu_name"].'" class="collapse ">';
						}
						$li .= '<ul class="nav">';
						foreach ($nav["subs"] as $key => $sub) {
							if (($sub["url"]) == "#") {
								$li .= '<li><a href="#">' . $nav["display_name"] . '</a></li>';
							} else {
								if ($sub_menu_name == $sub["sub_menu_name"]) {
									$li .= '<li><a href="' . base_url($sub["url"]) . '" class="active">' . $sub["display_name"] . '</a></li>';
								} else {
									$li .= '<li><a href="' . base_url($sub["url"]) . '" class="">' . $sub["display_name"] . '</a></li>';
								}
							}
						}
						$li .= '</ul></div></li>';
						echo $li;
					}
				}
				?>
			</ul>
		</nav>
	</div>
</div>
<?php
if(!defined('IN_TTAE')) exit('Access Denied'); 
class page {
	public static function multi($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10, $autogoto = FALSE, $simple = FALSE, $jsfunc = FALSE) {
		global $_G;
		if($_G[mobile]) $page = 2;
		
		
		$ajaxtarget = !empty($_GET['ajaxtarget']) ? " ajaxtarget=\"".dhtmlspecialchars($_GET['ajaxtarget'])."\" " : '';
		$a_name = '';
		
		if(strpos($mpurl, '#') !== FALSE) {
			$a_strs = explode('#', $mpurl);
			$mpurl = $a_strs[0];
					
			$a_name = '#'.$a_strs[1];
		}elseif($_G[page_end]){
			$a_name = $_G[page_end];
		}
		if($jsfunc !== FALSE) {
			$mpurl = 'javascript:'.$mpurl;
			$a_name = $jsfunc;
			$pagevar = '';
		} else {
			$pagevar = 'page=';
		}

			$shownum = $showkbd = FALSE;
			$showpagejump = TRUE;
			$lang['prev'] = '上一页';
			$lang['next'] = '下一页';
			$lang['pageunit'] = '当前';
			$lang['total'] = '共';
			$lang['pagejumptip'] = '跳转';
			
			

			$dot = '...';
			
			
			if($_G[mobile]) {
				$dot ='';
				$lang['prev'] = '上页';
				$lang['next'] = '下页';

			}
		$multipage = '';
		if($jsfunc === FALSE) {
			$mpurl .= strpos($mpurl, '?') !== FALSE ? '&amp;' : '?';
		}

		$realpages = 1;
		$_G['page_next'] = 0;
		$page -= strlen($curpage) - 1;
		if($page <= 0) {
			$page = 1;
		}
		
		if($num > $perpage) {

			$offset = floor($page * 0.5);

			$realpages = @ceil($num / $perpage);
			$curpage = $curpage > $realpages ? $realpages : $curpage;
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			
			$_G['page_next'] = $to;
			$multipage =($curpage > 1 && !$simple ? '<a href="'.$mpurl.$pagevar.($curpage - 1).$a_name.'" class="prev"'.$ajaxtarget.'>'.$lang['prev'].'</a>' : '<a  class="prev prevs">'.$lang['prev'].'</a>');
			$multipage .= ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.$pagevar.'1'.$a_name.'" class="first"'.$ajaxtarget.'>1 '.$dot.'</a>' : '');
			
			
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
				'<a href="'.$mpurl.$pagevar.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : $a_name).'"'.$ajaxtarget.'>'.$i.'</a>';
			}
			$multipage .= ($to < $pages ? '<a href="'.$mpurl.$pagevar.$pages.$a_name.'" class="last"'.$ajaxtarget.'>'.$dot.' '.$realpages.'</a>' : '').
			($showpagejump && !$simple && !$ajaxtarget ? '<label><span title="'.$lang['total'].' '.$pages.' '.$lang['pageunit'].'"> / '.$pages.' '.$lang['pageunit'].'</span></label>' : '').
			//($curpage < $pages && !$simple ? '<a href="'.$mpurl.$pagevar.($curpage + 1).$a_name.'" class="nxt"'.$ajaxtarget.'>'.$lang['next'].'</a>' : '');
			($curpage < $pages && !$simple ? '<a href="'.$mpurl.$pagevar.($curpage + 1).$a_name.'" class="nxt"'.$ajaxtarget.'>'.$lang['next'].'</a>' : '<a  class="nxt nexs">'.$lang['next'].'</a>');
			
			if ($_G[db]==1)  $multipage='';
			$multipage = $multipage ? '<div class="pg">'.($shownum && !$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'</div>' : '';
		}
		$maxpage = $realpages;
		
		$multipage = str_replace("&amp;",'&',$multipage);
		return $multipage;
	}

	public static function simplepage($num, $perpage, $curpage, $mpurl) {
		$return = '';
		$lang['next'] = '下一页';
		$lang['prev'] = '上一页';
		
		$next = $num == $perpage ? '<a href="'.$mpurl.'&amp;page='.($curpage + 1).'" class="nxt">'.$lang['next'].'</a>' : '';
		$prev = $curpage > 1 ? '<span class="pgb"><a href="'.$mpurl.'&amp;page='.($curpage - 1).'">'.$lang['prev'].'</a></span>' : '';
		if($next || $prev) {
			$return = '<div class="pg">'.$prev.$next.'</div>';
		}
		$return = str_replace("&amp;",'&',$return);
		
		return $return;
	}
}

?>
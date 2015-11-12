<DIV id=footer>
<DIV id=footer_contact>
<P><A href="http://andreamignolo.com/oulipo">Oulipo</A> by <A 
href="http://andreamignolo.com/">Mignolo</A> | Mod by <a href="http://sonics.co.tv/">Martin</a></P>
<P>Powered by <a href="http://www.typecho.org">Typecho)))</a></P></DIV>
<DIV id=footer_info><!-- ><p>You can put extra footer information here, just uncomment this line.</p> --></DIV></DIV>
</DIV><!-- close wrapper --><?php $this->footer(); ?>
<?php
if ($this->is('single')) {
    Helper::threadedCommentsScript();
}
?>
</BODY></HTML>
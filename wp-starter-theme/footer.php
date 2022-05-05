
    </div><!-- #content -->

    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
        <a id="scroll-to-top" class="outer ir-phark" href="#content">Scroll to Top</a>
        <div class="site-info widget-area">
            <div class="container">
                <div class="columns">
                    <div class="column-3">
                        <?php starter_is_active_sidebar( 'footer-widget-1' ); ?>
                    </div>
                    <div class="column-3">
                        <?php starter_is_active_sidebar( 'footer-widget-2' ); ?>
                    </div>
                    <div class="column-3">
                        <?php starter_is_active_sidebar( 'footer-widget-3' ); ?>
                    </div>
                    <div class="column-3">
                        <?php starter_is_active_sidebar( 'footer-widget-4' ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-copyright">
            <div class="container">
                <?php starter_the_copyright_text(array('skin'=>'github')); ?>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
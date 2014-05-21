<footer class="footer" role="contentinfo">
	<?php if (is_active_sidebar_YA('bottom')): ?>
	<div class="sidebar-bottom">
		<div class="container">
			<div class="row">
				<?php dynamic_sidebar('bottom'); ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="copyright">
		<div class="container">
			<div class="copyright-inner">
				<p>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo site_url()?>">Bloggers.com™.</a>. All rights reversed.</br>
<small>The trademark of BLOGGERS is vested in PARK IK WOO, and the Trademark (World Intellectual Property Organization / WIPO - No.829272) is enrolled in which Jun 24, 2003.</small>
			</div>
			<?php if ( is_active_sidebar_YA('footer') ): ?>
			<div class="sidebar-footer">
				<?php dynamic_sidebar('footer')?>
			</div>
			<?php endif; ?>	
		</div>
	</div>
</footer>
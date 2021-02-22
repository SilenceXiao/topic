<a href="<?php echo e(route('users.show',$user->id)); ?>">
	<img src="<?php echo e($user->gravatar('140')); ?>" alt="<?php echo e($user->name); ?>" class="gravatar"/>
</a>
<h1><?php echo e($user->name); ?></h1>
<?php /**PATH /home/vagrant/Code/topic/resources/views/shared/_user_info.blade.php ENDPATH**/ ?>
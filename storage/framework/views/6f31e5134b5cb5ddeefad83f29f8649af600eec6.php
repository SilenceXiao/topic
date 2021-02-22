
<?php $__env->startSection('title','用户列表'); ?>

<?php $__env->startSection('content'); ?>

	<div class="offset-md-2 col-md-8">
		<h2 class="mb-4 text-center">所有用户</h2>
		<div class="list-group list-group-flush">
		    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		      <!-- <div class="list-group-item">
		        <img class="mr-3" src="<?php echo e($user->gravatar()); ?>" alt="<?php echo e($user->name); ?>" width=32>
		        <a href="<?php echo e(route('users.show', $user)); ?>">
		          <?php echo e($user->name); ?>

		        </a>
		      </div> -->
		      <?php echo $__env->make('users._user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

		<div class="mt-3">
    		<?php echo $users->render(); ?>

  		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/Code/topic/resources/views/users/index.blade.php ENDPATH**/ ?>
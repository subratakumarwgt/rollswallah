
<style type="text/css">
  .float {
    position: absolute;
    right: 5px;
    top: 0px;
    margin: 1px;
  }

  .action_label {
    cursor: pointer;
  }

  .cursor-pointer {
    cursor: pointer;
  }

  .cursor-pointer:hover {
    color: black
  }
  .product:hover{
    box-shadow: 0px 2px 2px 2px rgba(0,0,0,0.1);
    border: rgba(0,100,0,0.9);
    border-radius: 0.2rem;
    cursor: pointer;
  }
  .img{
    min-height: 50px;
   
  }
  
  
</style>

    <div class="card-body">
        <div class="row">
        <div class="col pt-2 pb-2 pr-4 pl-4">
                <input type="text" class="form-control" placeholder="search for item">
            </div>
            <div class="col pt-2 pb-2 pr-4 pl-4">
                <select name="sub_category" id="sub_category" class="form-control">
                    <option value=""> Filter by subcategory</option>
                </select>
            </div>
            <div class="col pt-2 pb-2 pr-4 pl-4">
                <select name="sub_category" id="sub_category" class="form-control">
                    <option value=""> Filter by subcategory</option>
                </select>
            </div>
           
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-2 col-sm-6 col-6">
              <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.item-box','data' => ['item' => $item]]); ?>
<?php $component->withName('item-box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['item' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>   
            </div>            
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </div>
    </div>
    <div class="card-footer">
          <button class="btn btn-dark btn-sm m-2 order_draft" onclick="setAllData()"> <i class="fa fa-send"></i> Place Order </button>
          <button class="btn btn-success btn-sm m-2 " onclick="createBill()"> <i class="fa fa-inr"></i> Create Bill </button>
          <button class="btn btn-primary btn-sm m-2 order_draft" onclick="saveDraft()"> <i class="fa fa-save"></i> Save Draft </button>
          <button class="btn btn-danger btn-sm m-2 order_draft" onclick="cancelOrder()"> <i class="fa fa-times"></i> Cancel Order </button>
    </div>



<?php $__env->startPush('script'); ?>

<script>
  $("#from_date").prop('max', $("#to_date").val());
  $("#to_date").change(function() {
    $("#from_date").prop('max', $("#to_date").val());
  });
  $("#from_date").change(function() {
    $("#to_date").prop('min', $("#from_date").val());
  });

  
</script>




<!-- <script src="<?php echo e(asset('assets/js/datatable/datatables/datatable.custom.js')); ?>"></script> -->
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\subra\Documents\projects\rollswallah\resources\views/components/layouts/order-easy.blade.php ENDPATH**/ ?>
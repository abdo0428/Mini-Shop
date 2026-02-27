@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Admin - Products</h3>
  <button class="btn btn-primary" id="btnCreate">Create Product</button>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <table id="productsTable" class="table table-striped w-100">
      <thead>
        <tr>
          <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Active</th><th>Created</th><th></th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productId">

        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input class="form-control" id="name">
          </div>
          <div class="col-md-3">
            <label class="form-label">Price</label>
            <input class="form-control" id="price" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label">Stock</label>
            <input class="form-control" id="stock" type="number" min="0">
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div>
          <div class="col-md-4">
            <label class="form-label">Active</label>
            <select class="form-select" id="is_active">
              <option value="1">Yes</option>
              <option value="0">No</option>
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" id="saveProduct">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const modal = new bootstrap.Modal('#productModal');
  let table;

  function resetForm(){
    $('#productId').val('');
    $('#name,#description,#price,#stock').val('');
    $('#is_active').val('1');
  }

  $(function(){
    table = $('#productsTable').DataTable({
      ajax: "{{ route('admin.products.datatable') }}",
      columns: [
        {data:'id'},
        {data:'name'},
        {data:'price', render:(v)=> '$' + parseFloat(v).toFixed(2)},
        {data:'stock'},
        {data:'is_active', render:(v)=> v ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'},
        {data:'created_at'},
        {data:null, orderable:false, render:(row)=> `
          <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-outline-dark editBtn">Edit</button>
            <button class="btn btn-sm btn-outline-danger delBtn">Delete</button>
          </div>
        `}
      ]
    });

    $('#btnCreate').on('click', function(){
      resetForm();
      $('#modalTitle').text('Create Product');
      modal.show();
    });

    $('#productsTable').on('click', '.editBtn', function(){
      const data = table.row($(this).closest('tr')).data();
      $('#modalTitle').text('Edit Product #' + data.id);
      $('#productId').val(data.id);
      $('#name').val(data.name);
      $('#description').val(data.description || '');
      $('#price').val(data.price);
      $('#stock').val(data.stock);
      $('#is_active').val(data.is_active ? '1' : '0');
      modal.show();
    });

    $('#productsTable').on('click', '.delBtn', function(){
      const data = table.row($(this).closest('tr')).data();

      Swal.fire({
        icon:'warning',
        title:'Delete product?',
        text: data.name,
        showCancelButton:true,
        confirmButtonText:'Yes delete'
      }).then((r)=>{
        if(!r.isConfirmed) return;

        $.ajax({
          url: "{{ url('admin/products') }}/" + data.id,
          method: 'DELETE'
        }).done(()=>{
          Swal.fire({icon:'success', title:'Deleted', timer:800, showConfirmButton:false});
          table.ajax.reload(null,false);
        }).fail(()=>{
          Swal.fire({icon:'error', title:'Error', text:'Delete failed'});
        });
      });
    });

    $('#saveProduct').on('click', function(){
      const id = $('#productId').val();
      const payload = {
        name: $('#name').val(),
        description: $('#description').val(),
        price: $('#price').val(),
        stock: $('#stock').val(),
        is_active: $('#is_active').val()
      };

      const isEdit = !!id;

      $.ajax({
        url: isEdit ? ("{{ url('admin/products') }}/" + id) : "{{ route('admin.products.store') }}",
        method: isEdit ? 'PUT' : 'POST',
        data: payload
      }).done((res)=>{
        Swal.fire({icon:'success', title: res.message || 'Saved', timer:900, showConfirmButton:false});
        modal.hide();
        table.ajax.reload(null,false);
      }).fail((xhr)=>{
        const msg = xhr.responseJSON?.message || 'Validation error';
        Swal.fire({icon:'error', title:'Error', text: msg});
      });
    });
  });
</script>
@endpush
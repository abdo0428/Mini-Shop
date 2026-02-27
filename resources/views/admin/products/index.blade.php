@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">{{ __('lang.admin_products_title') }}</h3>
  <button class="btn btn-primary" id="btnCreate">{{ __('lang.create_product') }}</button>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <table id="productsTable" class="table table-striped w-100 align-middle">
      <thead>
        <tr>
          <th>{{ __('lang.id') }}</th>
          <th>{{ __('lang.image') }}</th>
          <th>{{ __('lang.name') }}</th>
          <th>{{ __('lang.price') }}</th>
          <th>{{ __('lang.stock') }}</th>
          <th>{{ __('lang.active') }}</th>
          <th>{{ __('lang.created') }}</th>
          <th></th>
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
        <h5 class="modal-title" id="modalTitle">{{ __('lang.product') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productId">

        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">{{ __('lang.name') }}</label>
            <input class="form-control" id="name">
          </div>
          <div class="col-md-3">
            <label class="form-label">{{ __('lang.price') }}</label>
            <input class="form-control" id="price" type="number" step="0.01">
          </div>
          <div class="col-md-3">
            <label class="form-label">{{ __('lang.stock') }}</label>
            <input class="form-control" id="stock" type="number" min="0">
          </div>
          <div class="col-12">
            <label class="form-label">{{ __('lang.description') }}</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div>
          <div class="col-md-4">
            <label class="form-label">{{ __('lang.active') }}</label>
            <select class="form-select" id="is_active">
              <option value="1">{{ __('lang.yes') }}</option>
              <option value="0">{{ __('lang.no') }}</option>
            </select>
          </div>
          <div class="col-md-8">
            <label class="form-label">{{ __('lang.image_help') }}</label>
            <input class="form-control" id="image" type="file" accept="image/png,image/jpeg">
            <div class="mt-2" id="imagePreview"></div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">{{ __('lang.close') }}</button>
        <button class="btn btn-success" id="saveProduct">{{ __('lang.save') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const modal = new bootstrap.Modal('#productModal');
  const storageBase = "{{ asset('storage') }}";
  const tNoImage = @json(__('lang.no_image'));
  const tYes = @json(__('lang.yes'));
  const tNo = @json(__('lang.no'));
  const tEdit = @json(__('lang.edit'));
  const tDelete = @json(__('lang.delete'));
  const tCreateProduct = @json(__('lang.create_product'));
  const tEditProduct = @json(__('lang.edit_product'));
  const tDeleteConfirm = @json(__('lang.delete_product_confirm'));
  const tYesDelete = @json(__('lang.yes_delete'));
  const tDeleted = @json(__('lang.deleted'));
  const tDeleteFailed = @json(__('lang.delete_failed'));
  const tValidationError = @json(__('lang.validation_error'));
  let table;

  function resetForm(){
    $('#productId').val('');
    $('#name,#description,#price,#stock').val('');
    $('#is_active').val('1');
    $('#image').val('');
    $('#imagePreview').html('');
  }

  function setPreview(imagePath){
    if(!imagePath){
      $('#imagePreview').html(`<span class="text-muted small">${tNoImage}</span>`);
      return;
    }
    const url = storageBase + '/' + imagePath;
    $('#imagePreview').html(`<img src="${url}" alt="Preview" style="height:70px" class="rounded border">`);
  }

  $(function(){
    table = $('#productsTable').DataTable({
      ajax: "{{ route('admin.products.datatable') }}",
      columns: [
        {data:'id'},
        {data:'image_url', render:(v, _t, row)=> {
          const url = v || (row.image ? `${storageBase}/${row.image}` : null);
          return url ? `<img src="${url}" style="height:36px" class="rounded border">` : '<span class="text-muted small">-</span>';
        }},
        {data:'name'},
        {data:'price', render:(v)=> '$' + parseFloat(v).toFixed(2)},
        {data:'stock'},
        {data:'is_active', render:(v)=> v ? `<span class="badge bg-success">${tYes}</span>` : `<span class="badge bg-secondary">${tNo}</span>`},
        {data:'created_at'},
        {data:null, orderable:false, render:(row)=> `
          <div class="d-flex justify-content-end gap-2">
            <button class="btn btn-sm btn-outline-dark editBtn">${tEdit}</button>
            <button class="btn btn-sm btn-outline-danger delBtn">${tDelete}</button>
          </div>
        `}
      ]
    });

    $('#btnCreate').on('click', function(){
      resetForm();
      $('#modalTitle').text(tCreateProduct);
      setPreview(null);
      modal.show();
    });

    $('#productsTable').on('click', '.editBtn', function(){
      const data = table.row($(this).closest('tr')).data();
      $('#modalTitle').text(`${tEditProduct} #${data.id}`);
      $('#productId').val(data.id);
      $('#name').val(data.name);
      $('#description').val(data.description || '');
      $('#price').val(data.price);
      $('#stock').val(data.stock);
      $('#is_active').val(data.is_active ? '1' : '0');
      $('#image').val('');
      setPreview(data.image || null);
      modal.show();
    });

    $('#productsTable').on('click', '.delBtn', function(){
      const data = table.row($(this).closest('tr')).data();

      Swal.fire({
        icon:'warning',
        title: tDeleteConfirm,
        text: data.name,
        showCancelButton:true,
        confirmButtonText: tYesDelete
      }).then((r)=>{
        if(!r.isConfirmed) return;

        $.ajax({
          url: "{{ url('admin/products') }}/" + data.id,
          method: 'DELETE'
        }).done(()=>{
          Swal.fire({icon:'success', title: tDeleted, timer:800, showConfirmButton:false});
          table.ajax.reload(null,false);
        }).fail(()=>{
          Swal.fire({icon:'error', title:'Error', text: tDeleteFailed});
        });
      });
    });

    $('#saveProduct').on('click', function(){
      const id = $('#productId').val();
      const payload = new FormData();

      payload.append('name', $('#name').val());
      payload.append('description', $('#description').val());
      payload.append('price', $('#price').val());
      payload.append('stock', $('#stock').val());
      payload.append('is_active', $('#is_active').val());

      const imageFile = document.getElementById('image').files[0];
      if(imageFile) payload.append('image', imageFile);

      const isEdit = !!id;
      if (isEdit) payload.append('_method', 'PUT');

      $.ajax({
        url: isEdit ? ("{{ url('admin/products') }}/" + id) : "{{ route('admin.products.store') }}",
        method: 'POST',
        data: payload,
        processData: false,
        contentType: false
      }).done((res)=>{
        Swal.fire({icon:'success', title: res.message || '{{ __('lang.saved') }}', timer:900, showConfirmButton:false});
        modal.hide();
        table.ajax.reload(null,false);
      }).fail((xhr)=>{
        const msg = xhr.responseJSON?.message || tValidationError;
        Swal.fire({icon:'error', title:'Error', text: msg});
      });
    });
  });
</script>
@endpush

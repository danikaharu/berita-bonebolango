<td>
    @can('view category')
        <a href="{{ route('categories.show', $model->slug) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    @can('edit category')
        <a href="{{ route('categories.edit', $model->slug) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('delete category')
        <form action="{{ route('categories.destroy', $model->slug) }}" method="post" class="d-inline"
            onsubmit="return confirm('Anda yakin ingin menghapusnya?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

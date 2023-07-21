<td>
    @can('view pressrelease')
        <a href="{{ route('press-releases.show', $model->slug) }}" class="btn btn-outline-success btn-sm">
            <i class="fa fa-eye"></i>
        </a>
    @endcan

    @can('edit pressrelease')
        <a href="{{ route('press-releases.edit', $model->slug) }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-pencil-alt"></i>
        </a>
    @endcan

    @can('delete pressrelease')
        <form action="{{ route('press-releases.destroy', $model->slug) }}" method="post" class="d-inline"
            onsubmit="return confirm('Are you sure to delete this record?')">
            @csrf
            @method('delete')

            <button class="btn btn-outline-danger btn-sm">
                <i class="ace-icon fa fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>

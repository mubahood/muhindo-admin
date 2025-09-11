<div class="box grid-box pt-2" style="border-top: none;" id="{{ $grid->tableID }}-box">
    @if (isset($title))
        <div class="box-header with-border">
            <h3 class="box-title"> {{ $title }}</h3>
        </div>
    @endif

    @if ($grid->showTools() || $grid->showExportBtn() || $grid->showCreateBtn())
        <div class="box-header with-border grid-toolbar-container">
            <div class="grid-toolbar d-flex justify-content-between align-items-center flex-wrap">
                <!-- Left Side Tools -->
                <div class="grid-toolbar-left d-flex align-items-center">
                    @if ($grid->showTools())
                        <div class="grid-header-tools">
                            {!! $grid->renderHeaderTools() !!}
                        </div>
                    @endif
                </div>

                <!-- Right Side Actions -->
                <div class="grid-toolbar-right d-flex align-items-center gap-2">
                    <div class="grid-action-buttons btn-group">
                        {!! $grid->renderColumnSelector() !!}
                        {!! $grid->renderExportButton() !!}
                        {!! $grid->renderCreateButton() !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover grid-table" id="{{ $grid->tableID }}">
            <thead>
                <tr>
                    @foreach ($grid->visibleColumns() as $column)
                        <th {!! $column->formatHtmlAttributes() !!}>{!! $column->getLabel() !!}{!! $column->renderHeader() !!}</th>
                    @endforeach
                </tr>
            </thead>

            @if ($grid->hasQuickCreate())
                {!! $grid->renderQuickCreate() !!}
            @endif

            <tbody>

                @if ($grid->rows()->isEmpty() && $grid->showDefineEmptyPage())
                    @include('admin::grid.empty-grid')
                @endif

                @foreach ($grid->rows() as $row)
                    <tr {!! $row->getRowAttributes() !!}>
                        @foreach ($grid->visibleColumnNames() as $name)
                            <td {!! $row->getColumnAttributes($name) !!}>
                                {!! $row->column($name) !!}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

            {!! $grid->renderTotalRow() !!}

        </table>

    </div>

    {!! $grid->renderFooter() !!}

    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>

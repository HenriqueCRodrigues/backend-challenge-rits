<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn(' ', function(Order $order) {
                $insert = '';
                //$statuses = ['Pendente', 'Em preparo', 'Em entrega', 'Entregue', 'Cancelado'];
                

                $insert = '<form action="'.route('web.orders.status', ['orderId' => $order->id]).'" method="POST">
                <a class="dropdown-item" href="#"><button style="border:none;background-color: #ffffff;
                border-color: transparent;padding:0;" type="submit">Pendente</Button></a>
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="status" value="Pendente">
                </form>
                <form action="'.route('web.orders.status', ['orderId' => $order->id]).'" method="POST">
                <a class="dropdown-item" href="#"><button style="border:none;background-color: #ffffff;
                border-color: transparent;padding:0;" type="submit">Em Preparo</Button></a>
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="status" value="Em Preparo">
                </form>
                <form action="'.route('web.orders.status', ['orderId' => $order->id]).'" method="POST">
                <a class="dropdown-item" href="#"><button style="border:none;background-color: #ffffff;
                border-color: transparent;padding:0;" type="submit">Em entrega</Button></a>
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="status" value="Em entrega">
                </form>
                <form action="'.route('web.orders.status', ['orderId' => $order->id]).'" method="POST">
                <a class="dropdown-item" href="#"><button style="border:none;background-color: #ffffff;
                border-color: transparent;padding:0;" type="submit">Entregue</Button></a>
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="status" value="Entregue">
                </form>
                <form action="'.route('web.orders.status', ['orderId' => $order->id]).'" method="POST">
                <a class="dropdown-item" href="#"><button style="border:none;background-color: #ffffff;
                border-color: transparent;padding:0;" type="submit">Cancelado</Button></a>
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="status" value="Cancelado">
                </form>';

                $html = '<div class="dropdown show">
                    <a class="btn btn-warning dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Change Status
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        '.$insert.'
                    </div>
                </div>';
                return $html;
            })
            ->addColumn('', function(Order $order) {
               return '<form action="'.route('web.orders.delete', ['orderId' => $order->id]).'" method="POST">
                    <input class="btn btn-danger" type="submit" value="Delete" />
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                </form>';
            })
            ->rawColumns(['link', ' ', '']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        //return $model->newQuery();
        $data = Order::select();
        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('csv'),
                        Button::make('excel'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('customer_id'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::make(' '),
            Column::make(''),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Orders_' . date('YmdHis');
    }
}

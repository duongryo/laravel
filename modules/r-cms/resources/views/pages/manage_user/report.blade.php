@extends('rcms::layout.index')
@section('content')

@component('rcms::components.breadcrumb')
@slot('title') User's Information @endslot
@endcomponent

<!-- Content -->
<div class="row ">
    <div class="col-12">
        <div class="row">
            <div class="col-12 ">
                <!-- Profile -->
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-body">
                        <div class="row">
                            <div class="col-auto avatar-box">
                                <div class="w-100">
                                    <img src="/themes/rsolution/img/icon/avatar.svg" width="150">
                                </div>
                            </div>
                            <div class="col-3">
                                <h6 class="font-weight-bold mb-3 text-primary">Information</h6>
                                <h6><strong>Name:</strong> {{ $data->name }}</h6>
                                <h6><strong>Last name:</strong> {{ $data->last_name }}</h6>
                                <h6><strong>Email:</strong> {{ $data->email }}</h6>
                                <h6><strong>Phone:</strong> {{ $data->phone }}</h6>
                                <h6><strong>Verified:</strong> {{ $data->email_verified_at ? 'Yes' : 'No' }}</h6>
                                <h6><strong>Status:</strong> {{ $data->status ? 'Activated' : 'Locked' }}</h6>
                                @if($data->role == RSolution\RCms\Repositories\UserRepository::ROLE_TESTER)
                                <span class="badge badge-primary">Tester</span>
                                @endif
                            </div>
                            <div class="col-3">
                                <h6 class="font-weight-bold mb-3 text-primary">Detail</h6>
                                <h6><strong>Gender:</strong> {{ $data->gender ? 'Nữ' : 'Nam' }}</h6>
                                <h6><strong>Birth:</strong> {{ $data->birth }}</h6>
                                <h6><strong>Credits: </strong>{{$data->credit}}</h6>
                                <h6><strong>Reffered by: </strong>
                                    @if($data->agent)
                                    <a href="{{route('rcms.manage-user.index')}}/{{$data->agent->id}}">{{ $data->agent->email }}</a>
                                    @else
                                    {{'---'}}
                                    @endif
                                </h6>
                                <h6>
                                    <strong>Refferers: </strong>
                                    <a href="#" data-toggle="modal" data-target="#modal-referrals" class="text-primary font-weight-medium">{{ count($data->referrals)}} <i class="fas fa-chart-line"></i> </a>
                                </h6>

                            </div>
                            <div class="col">
                                <h6 class="font-weight-bold mb-3 text-primary">Plan information</h6>
                                <h6><strong>Signup at:</strong> {{ $data->created_at->format('d/m/Y') }}</h6>
                                <h6><strong>Plan:</strong>
                                    {{ @$data->planInfo->name }}
                                </h6>
                                <h6><strong>Expiration date:</strong> {{ $data->activation ? $data->activation->expiration_date  : '---'}}</h6>
                                <!-- Update Modal -->
                                <h6><strong>Keyword Credit:</strong>
                                    {{ number_format(@$data->keyword_value) }}

                                    (one time)
                                </h6>
                                <h6><strong>A.I Credit:</strong>
                                    {{ number_format(@$data->content_value) }}
                                    (one time)
                                </h6>
                            </div>


                        </div>
                        <div class="row mt-15">
                            <div class="col">
                                <button class="btn btn-outline-primary btn-sm mr-1" type="button" data-toggle="modal" data-target="#modal-tester">
                                    <i class="fas fa-flag "></i>
                                    {{ $data->role == RSolution\RCms\Repositories\UserRepository::ROLE_TESTER ? 'Disable Tester' : 'Enable Tester' }}
                                </button>

                                <button class="btn btn-outline-primary btn-sm mr-1" type="button" data-toggle="modal" data-target="#modal-block">
                                    <i class="fal {{ $data->status ? 'fa-lock' : 'fa-key' }}"></i>
                                    {{ $data->status ? 'Lock' : 'Unlock' }}
                                </button>
                                <a href="{{ route('rcms.login-as-user') }}?id={{ $data->id }}" class="btn btn-outline-primary btn-sm mr-1">Login as User</a>

                            </div>
                            <div class="col-auto">
                                <a href="{{ route('rcms.user-log.index') }}/{{ $data->id }}" class="btn btn-primary btn-sm  mr-1">User's logs</a>
                                <a href="{{ route('rcms.manage-user.usage', $data->id) }}" class="btn btn-primary btn-sm  mr-1">Remaining Limit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <!-- Logs -->
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <span class="title">Transactions</span>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-sm mr-1" type="button" data-toggle="modal" data-target="#modal-upgrade">
                                    <i class="fas fa-arrow-circle-up"></i> Upgrade</button>
                                @if(count($data->transactions))
                                <button class="btn btn-outline-primary  btn-sm " type="button" data-toggle="modal" data-target="#modal-renew"><i class="fas fa-award"></i> Renew</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <table class="table rsolution-table border">
                            <thead>
                                <tr class="align-middle">
                                    <th class="id">#</th>
                                    <th class="text-left">Action</th>
                                    <th class="text-center">From plan</th>
                                    <th class="text-center">To plan</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Method</th>
                                    <th class="text-right" colspan="2">Note</th>
                                    <th class="text-center">Plan time</th>
                                    <th class="text-right">Created at</th>
                                    <th class="text-right">Status</th>
                                    <th class="text-right id">-</th>
                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar" style="max-height:400px">
                                @foreach($data->transactions as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + 1 }}</td>
                                    <td class="text-left">{{ $item->type == 'upgrade' ? 'Upgrade' : 'Renew' }}</td>
                                    <td class="text-center">{{ @$item->fromPlanInfo->name }}</td>
                                    <td class="text-center">{{ @$item->toPlanInfo->name }}</td>
                                    <td class="text-center">{{ number_format($item->amount) }}$</td>
                                    <td class="text-center">{{ $item->method }}</td>
                                    <td class="text-right" colspan="2">{{ $item->note }}</td>
                                    <td class=" text-center">{{ $item->plan_time }} days</td>
                                    <td class="text-right">{{ $item->created_at }}</td>
                                    <td class="text-right">
                                        @if($item->status)
                        
                                        <span class="badge badge-success">Paid</span>
                                        @else
                                        <span class="badge badge-danger">Refunded</span>
                                        @endif

                                    </td>
                                    <td class="text-right id">
                                        @if($item->activation && $item->activation->id)
                                        <button class="btn btn-sm btn-icon" type="button" data-toggle="modal" data-target="#modal-destroy"><i class="fas fa-trash"></i></button>
                                        <div class="modal fade text-left" id="modal-destroy" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                @if($item->method == 'stripe')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-addLabel">Cancel Transaction</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Contact Super Admin to do this action
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                @elseif($item->method == 'appsumo' || $item->method == 'stacksocial')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-addLabel">Cancel Transaction</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Use Disable LTD code function
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                @else
                                                <form class="modal-content" method="post" action="{{ route('rcms.activation.destroy') }}">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal-addLabel">Cancel Transaction</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Cancel this transaction will remove the user's current plan</p>
                                                        <input name="id" value="{{$item->id}}" hidden />
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" id="customCheck3" type="checkbox" required>
                                                            <label class="custom-control-label pt-0" for="customCheck3">Confirm</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary btn-submit btn-sm">Confirm</button>
                                                    </div>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if(!$data->transactions->count() )
                                <tr class="align-middle">
                                    <td class="text-center">No data</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Keyword Value History -->
            <div class="col-12">
                <div class="rsolution-card-shadow">
                    <div class="rsolution-card-header border-bottom">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <span class="title">Credit Transactions</span>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-sm mr-1" type="button" data-toggle="modal" data-target="#modal-add-keyword-value">
                                    <i class="fas fa-dollar"></i> Add Credit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="rsolution-card-body">
                        <table class="table rsolution-table border">
                            <thead>
                                <tr class="align-middle">
                                    <th class="id">#</th>
                                    <th class="text-center">Keyword Credit</th>
                                    <th class="text-center">Content Credit</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-right">Note</th>
                                    <th class="text-right">Created at</th>
                                    <th class="text-right">Status</th>

                                </tr>
                            </thead>
                            <tbody class="rsolution-scrollbar" style="max-height:400px">
                                @foreach($data->valueTransactions as $index => $item)
                                <tr class="align-middle">
                                    <td class="id">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $item->keyword_value }}</td>
                                    <td class="text-center">{{ $item->content_value }}</td>
                                    <td class="text-center">{{ number_format($item->amount) }}đ</td>
                                    <td class="text-right text-truncate" style="max-width:200px">{{ $item->note }}</td>
                                    <td class="text-right">{{ $item->created_at }}</td>
                                    <td class="text-right">{{ $item->status ? 'Paid' : 'Refunded' }}</td>

                                </tr>
                                @endforeach
                                @if(!$data->valueTransactions->count() )
                                <tr class="align-middle">
                                    <td class="text-center">Không có dữ liệu</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upgrade -->
<div class="modal fade" id="modal-upgrade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ route('rcms.activation.upgrade') }}" id="modal-form-upgrade">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Nâng cấp tài khoản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input name="user_id" value="{{$data->id}}" hidden required />
                <input name="from_plan" value="{{$data->plan}}" hidden required />
                <div class="form-group">
                    <label>Gói nâng cấp</label>
                    <select class="form-control" name="to_plan" required>
                        @foreach($plans as $plan)
                        @if($plan->id != 1)
                        <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Thời hạn (ngày)</label>
                    <input class="form-control" type="number" name="plan_time" value="30" required>
                </div>
                <div class="form-group">
                    <label>Số tiền thanh toán</label>
                    <input class="form-control" type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="note" form="modal-form-upgrade"></textarea>
                </div>
                <div class="form-group">
                    <p><strong>Lưu ý:</strong> khi sử dụng chức năng nâng cấp. Gói đang sử dụng (nếu có) sẽ được hủy bỏ, thay vào đó là gói mới với ngày kích hoạt bắt đầu là hôm nay.</p>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="customCheck1" type="checkbox" required>
                    <label class="custom-control-label pt-0" for="customCheck1">Xác nhận các thông tin nâng cấp</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-submit btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Renew -->
<div class="modal fade" id="modal-renew" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ route('rcms.activation.renew') }}" id="modal-form-renew">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Gia hạn tài khoản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input name="user_id" value="{{$data->id}}" hidden required />
                <input name="from_plan" value="{{$data->plan}}" hidden required />
                <input name="type" value="renew" hidden required />

                <div class="form-group">
                    <label>Gói đang sử dụng</label>
                    <input class="form-control-plaintext" type="text" readonly value="{{ @$data->planInfo->name }}">
                    <input name="to_plan" value="{{ $data->plan }}" hidden>
                </div>

                <div class="form-group">
                    <label>Thời hạn (ngày)</label>
                    <input class="form-control" type="number" name="plan_time" value="30" required>
                </div>
                <div class="form-group">
                    <label>Số tiền thanh toán</label>
                    <input class="form-control" type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="note" form="modal-form-renew"></textarea>
                </div>
                <div class="form-group">
                    <p><strong>Lưu ý:</strong> khi sử dụng chức năng gia hạn. Gói đang sử dụng (nếu có) sẽ được cộng dồn ngày sử dụng với gói mới. Ngày hết hạn mới sẽ được tính bằng ngày hết hạn cũ + thời hạn gói mới.</p>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="customCheck2" type="checkbox" required>
                    <label class="custom-control-label pt-0" for="customCheck2">Xác nhận các thông tin gia hạn</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-submit btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Referrals -->
<div class="modal fade" id="modal-referrals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Những user đã giới thiệu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="mt-3 table rsolution-table">
                    <thead>
                        <tr class="align-middle">
                            <th class="id">#</th>
                            <th class="text-center">Tên</th>
                            <th style="width: 250px;">Email</th>
                            <th class="text-center">Thời gian đăng ký</th>
                            <th class="text-center">Lần cuối đăng nhập</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="rsolution-scrollbar">
                        @if(!$data->referrals->count() )
                        <tr class="align-middle">
                            <td class="text-center">Không có dữ liệu</td>
                        </tr>
                        @endif
                        @foreach($data->referrals as $index => $item)
                        <tr class="align-middle">
                            <td class="id">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->name }}</td>
                            <td style="width: 250px;">{{ $item->email }}</td>
                            <td class="text-center">{{ $item->created_at }}</td>
                            <td class="text-center">{{ $item->last_login }}</td>
                            <td class="text-right">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('rcms.manage-user.index') }}/{{ $item->id }}">Chi tiết</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal block -->
<div class="modal fade text-left" id="modal-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ !empty($route) ? $route : Request::url()}}" id="modal-form-update">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Xác nhận hành động</p>
                <input name="status" value="{{ $data->status ? 0 : 1 }}" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal tester -->
<div class="modal fade text-left" id="modal-tester" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ !empty($route) ? $route : Request::url()}}" id="modal-form-update">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Xác nhận hành động</p>
                <input name="role" value="{{$data->role == RSolution\RCms\Repositories\UserRepository::ROLE_TESTER ? RSolution\RCms\Repositories\UserRepository::ROLE_MEMBER : RSolution\RCms\Repositories\UserRepository::ROLE_TESTER}}" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal add value -->
<div class="modal fade" id="modal-add-keyword-value" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" action="{{ route('rcms.activation.add_keyword_value') }}" id="modal-form-add-value">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Add Credit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input name="user_id" value="{{$data->id}}" hidden required />

                <div class="form-group">
                    <label>Keyword Credit</label>
                    <input class="form-control" type="number" name="keyword_value" required>
                </div>

                <div class="form-group">
                    <label>Content Credit</label>
                    <input class="form-control" type="number" name="content_value" required>
                </div>

                <div class="form-group">
                    <label>Số tiền thanh toán</label>
                    <input class="form-control" type="number" name="amount" required>
                </div>

                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="note" form="modal-form-add-value"></textarea>
                </div>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="customCheck-44" type="checkbox" required>
                    <label class="custom-control-label pt-0" for="customCheck-44">Xác nhận các thông tin nâng cấp</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary btn-submit btn-sm">Xác nhận</button>
            </div>
        </form>
    </div>
</div>

@section('js')
<script>
    // A $( document ).ready() block.
    $("form").submit(function(event) {
        $('.btn-submit').prop('disabled', true);
    });
</script>
@endsection
@endsection
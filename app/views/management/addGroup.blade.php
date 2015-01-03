@extends('management.groupManagement')
@section('addEditGroup')
	<br>
    <h2 class="panel-title onlythaibold" style="font-size:25px;"><i class="fa fa-plus-circle fa-fw" style="color:green;"></i> เพิ่มกลุ่มตัวอย่างใหม่</h2>
    <br>
    @if (Session::get('error'))
        <div class="alert alert-danger">
        @if (is_array(Session::get('error')))
            {{ head(Session::get('error')) }}
        @else
            {{{ Session::get('error') }}}
        @endif
        </div>
    @endif
    @if (Session::get('notice'))
        <div class="alert alert-success">{{ Session::get('notice') }}</div>
    @endif
    {{Form::open(array('url' => '/groupManagement','method'=>'post','class' => 'form-horizontal','accept-charset'=>'UTF-8'))}}
    <div class="form-group">

        <label for="name" class="col-sm-3 control-label">ชื่อกลุ่ม <span class="required">*</span></label>
        <div class="col-sm-5">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'ชื่อกลุ่ม', 'required' => 'required']) }}
            <label class="control-label" style="color:darkred; font-size:12px;">&nbsp; หมายเหตุ: ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า</label>
        </div>     
        
        <!-- <span class="glyphicon glyphicon-info-sign" style="font-size:15px;" aria-hidden="true" data-toggle="tooltip" title="ชื่อกลุ่มต้องไม่ซ้ำกับกลุ่มอื่นๆที่มีอยู่ก่อนหน้า"></span>                -->
    </div><!--form-group-->
    <div class="form-group">
        <label for="description" class="col-sm-3 control-label">รายละเอียดของกลุ่ม </label>
        <div class="col-sm-8">
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'รายละเอียดของกลุ่ม', 'cols' => '30', 'rows' => '3']) }}
        </div>
    </div><!--form-group-->
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-8">
            {{ Form::submit('บันทึก', array('class'=>'btn btn-success'))}}
        </div>
    </div>
@stop
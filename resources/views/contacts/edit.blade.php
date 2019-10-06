@extends('base')

@section('main')
<div class="row">
 <div class="col-sm-12">
    <h3>Add Contact</h3>
  <div>
    {{ Form::model($contact,['role' => 'form','route' =>array("contacts.update",$contact->id),'class' => '', 'files' => true]) }}
    @method('PUT')

          <div class="row">
            <div class="form-group col-sm-6">
              {{  Form::label('first_name',trans('First Name').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('first_name',null,array('placeholder'=>trans('First Name'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('first_name'); ?>
  							</div>
            </div>

            <div class="form-group col-sm-6">
              {{  Form::label('last_name',trans('Last Name').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('last_name',null,array('placeholder'=>trans('Last Name'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('last_name'); ?>
  							</div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-6">
              {{  Form::label('email',trans('Email').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('email',null,array('placeholder'=>trans('Email'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('email'); ?>
  							</div>
            </div>

            <div class="form-group col-sm-6">
              {{  Form::label('phone',trans('Phone Number').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('phone',null,array('placeholder'=>trans('Phone Number'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('phone'); ?>
  							</div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-12">
              {{  Form::label('subject',trans('Subject').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('subject',null,array('placeholder'=>trans('Subject'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('subject'); ?>
  							</div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-sm-12">
              {{  Form::label('message',trans('Message').'<span class="requireRed"> * </span>', ['class' => ''],false) }}
              {{ Form::text('message',null,array('placeholder'=>trans('Message'),'class'=>'form-control')) }}
                <div class="error-message help-inline">
  								<?php echo $errors->first('message'); ?>
  							</div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
          <a class="btn btn-danger" href="{{route('contacts.index')}}">Back</a>
      {{ Form::close() }}
  </div>
</div>
</div>
@endsection

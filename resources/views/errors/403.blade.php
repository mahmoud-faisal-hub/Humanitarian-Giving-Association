@extends('errors::layout')

@section('title', 'ممنوع الدخول لهذه الصفحة')
@section('code', arabicNumbers('403'))
@section('message', $exception->getMessage() ?: 'ممنوع الدخول لهذه الصفحة')

@extends('claim.layout.default')

@section('main_content')
<div class="card">
  <div class="card-header">
    Scrollspy
    <small>with list-group</small>
  </div>
  <div class="card-body">
    <div class="row bd-example2">
      <div class="col-4">
        <div id="list-float-data" class="list-group">
          <a class="list-group-item list-group-item-action active" href="#base-info">Base Info</a>
          <a class="list-group-item list-group-item-action" href="#patient-info">Patient Info</a>
          <a class="list-group-item list-group-item-action" href="#package-info">Package Info</a>
          <a class="list-group-item list-group-item-action" href="#hospital-info">TPA Info</a>
          <a class="list-group-item list-group-item-action" href="#tpa-info">Hospital Info</a>
        </div>
      </div>
      <div class="col-8">
        <div id="spy-example2" data-spy="scroll" data-target="#list-float-data" data-offset="0" style="height: 200px; overflow: auto">
          <h4 id="base-info">Item 1</h4>
          <p>Ex consequat commodo adipisicing exercitation aute excepteur occaecat ullamco duis aliqua id magna ullamco eu. Do aute ipsum ipsum ullamco cillum consectetur ut et aute consectetur labore. Fugiat laborum incididunt tempor eu consequat
            enim dolore proident. Qui laborum do non excepteur nulla magna eiusmod consectetur in. Aliqua et aliqua officia quis et incididunt voluptate non anim reprehenderit adipisicing dolore ut consequat deserunt mollit dolore. Aliquip
            nulla enim veniam non fugiat id cupidatat nulla elit cupidatat commodo velit ut eiusmod cupidatat elit dolore.</p>
          <h4 id="patient-info">Item 2</h4>
          <p>Quis magna Lorem anim amet ipsum do mollit sit cillum voluptate ex nulla tempor. Laborum consequat non elit enim exercitation cillum aliqua consequat id aliqua. Esse ex consectetur mollit voluptate est in duis laboris ad sit ipsum
            anim Lorem. Incididunt veniam velit elit elit veniam Lorem aliqua quis ullamco deserunt sit enim elit aliqua esse irure. Laborum nisi sit est tempor laborum mollit labore officia laborum excepteur commodo non commodo dolor excepteur
            commodo. Ipsum fugiat ex est consectetur ipsum commodo tempor sunt in proident.</p>
          <h4 id="package-info">Item 3</h4>
          <p>Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore
            velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>
          <h4 id="hospital-info">Item 4</h4>
          <p>Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore
            velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>

            <h4 id="tpa-info">Item 4</h4>
          <p>Quis anim sit do amet fugiat dolor velit sit ea ea do reprehenderit culpa duis. Nostrud aliqua ipsum fugiat minim proident occaecat excepteur aliquip culpa aute tempor reprehenderit. Deserunt tempor mollit elit ex pariatur dolore
            velit fugiat mollit culpa irure ullamco est ex ullamco excepteur.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
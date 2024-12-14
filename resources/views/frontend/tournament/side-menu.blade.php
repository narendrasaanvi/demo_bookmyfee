<div class="row text-center py-3">
  <div class="col-md-3 mb-2">
    <a href="{{ url('tournament-create') }}"
       class="btn w-100 {{ request()->is('tournament-create') ? 'btn-success' : 'btn-primary' }}">
      Add a Tournament
    </a>
  </div>
  <div class="col-md-3 mb-2">
    <a href="{{ url('tournament-view') }}"
       class="btn w-100 {{ request()->is('tournament-view') ? 'btn-success' : 'btn-primary' }}">
       Tournament List
    </a>
  </div>
</div>

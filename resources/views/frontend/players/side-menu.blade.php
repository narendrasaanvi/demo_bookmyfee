<div class="row text-center py-3">
  <div class="col-md-3 mb-2">
    <a href="{{ url('player-registration') }}"
       class="btn w-100 {{ request()->is('player-registration') ? 'btn-success' : 'btn-primary' }}">
      Add a New Player
    </a>
  </div>
  <div class="col-md-3 mb-2">
    <a href="{{ url('player-registration/view') }}"
       class="btn w-100 {{ request()->is('player-registration/view') ? 'btn-success' : 'btn-primary' }}">
       Edit Player
    </a>
  </div>
  <div class="col-md-3 mb-2">
    <a href="https://registration.tamilchess.com/new-register/"
       class="btn w-100 {{ request()->is('tournaments') ? 'btn-success' : 'btn-primary' }}"  target="_blank">
      TNSCA
    </a>
  </div>
  <div class="col-md-3 mb-2">
    <a href="https://prs.aicf.in/new-register"
       class="btn w-100 {{ request()->is('tournaments') ? 'btn-success' : 'btn-primary' }}" target="_blank">
      AICF
    </a>
  </div>
</div>

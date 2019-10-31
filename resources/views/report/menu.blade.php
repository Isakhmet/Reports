<div class="col-md-3">
    <div class="ui vertical menu">

            <div class="item">
                <div class="header">CRM</div>
                <div class="menu">
                    @foreach($reports as $key => $value)
                        @if ($value->category == 'crm')
                    <a class="item">{{ $value->description }}</a>
                        @endif
                        @endforeach
                </div>
            </div>

            <div class="item">
                <div class="header">Oracle</div>
                <div class="menu">
                    @foreach($reports as $key => $value)
                        @if ($value->category == 'oracle')
                    <a class="item">{{ $value->description }}</a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="item">
                <div class="header">SMS Campaign Manager</div>
                <div class="menu">
                    @foreach($reports as $key => $value)
                        @if ($value->category == 'smscm')
                    <a class="item">{{ $value->description }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
    </div>
</div>
<!doctype html>
<html>
  <head>
    <title>De Gouden Draak - Menukaart</title>
    <style>
      .center {
        text-align: center;
      }

      .type {
        margin: 2rem 0;
      }

      .menu-item {
        display: inline-block;
        width: 50%;
        padding: 1rem;
        vertical-align: top;
      }

      .menu-header > * {
        display: inline-block;
      }

      .menu-header > *:last-child {
        float: right;
      }
    </style>
  </head>
  <body>
    @foreach ($types as $type)
      <h2 class="type center">
        {{ $type->name }}
      </h2>
      <div class="menu">
        @foreach($type->dishes as $dish)
          <div class="menu-item">
            <div class="menu-header">
              <h3>{{ $dish->number }}. {{ $dish->name }}</h3>
              <span>&euro;{{ number_format($dish->price, 2, '.', '') }}</span>
            </div>
            @if($dish->description)
              <p>
                ({{ $dish->description }})
              </p>
            @endif
          </div>
        @endforeach
      </div>
    @endforeach
  </body>
</html>

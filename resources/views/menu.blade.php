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

      .menu {
        display: flex;
        flex-wrap: wrap;
      }

      .menu-item {
        flex: 0 0 50%;
        padding: 1rem;
      }

      .menu-header {
        display: flex;
        align-items: center;
      }

      .spacer {
        flex: 1;
        height: 1px;
        margin: 0 0.5rem;
        border-bottom: 1px dashed black;
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
              <span class="spacer"/>
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

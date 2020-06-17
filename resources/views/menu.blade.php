<!doctype html>
<html>
  <head>
    <title>De Gouden Draak - Menukaart</title>
  </head>
  <body>
    <h1>Gouden Draak menukaart</h1>
    @foreach ($types as $type)
      <h4>{{ $type->name }}</h4>
      <ul>
        @foreach($type->dishes as $dish)
          <div @if($dish->description) style="margin-bottom: 20px" @endif>
            <li style="list-style: none;">
            <span style="margin-right: 10px; text-align: left">
              {{ $dish->number }}
            </span>
              {{ $dish->name }}
              <span style="text-align: right">
              &euro;{{ number_format($dish->price, 2, '.', '') }}
            </span>
            </li>
            @if($dish->description)
              <span style="font-size: 12px;">
            ({{ $dish->description }})
          </span>
            @endif
          </div>
        @endforeach
      </ul>
    @endforeach
    <h3>Aanbiedingen</h3>
    @foreach ($offers as $offer)
      <h4>{{ $offer->name }} &euro;{{ number_format($offer->price, 2, '.', '') }}</h4>
      <ul>
        @foreach($offer->dishes as $dish)
          <div @if($dish->description) style="margin-bottom: 20px" @endif>
            <li style="list-style: none;">
            <span style="margin-right: 10px; text-align: left">
              {{ $dish->number }}
            </span>
              {{ $dish->name }}
            </li>
            @if($dish->description)
              <span style="font-size: 12px;">
              ({{ $dish->description }})
            </span>
            @endif
          </div>
        @endforeach
      </ul>
    @endforeach
  </body>
</html>

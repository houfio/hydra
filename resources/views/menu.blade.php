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
          <li style="list-style: none;">
            <span style="margin-right: 10px; text-align: left">
              {{ $dish->number }}
            </span>
            {{ $dish->name }}
            <span style="text-align: right">
              &euro;{{ number_format($dish->price, 2, '.', '') }}
            </span>
          </li>
        @endforeach
      </ul>
    @endforeach
    <h3>Aanbiedingen</h3>
    @foreach ($offers as $offer)
      <h4>{{ $offer->name }}</h4>
      <ul>
        @foreach($offer->dishes as $dish)
          <li style="list-style: none;">
            {{ $dish->number }} {{ $dish->name }} &euro;{{ number_format($dish->price, 2, '.', '') }}
          </li>
        @endforeach
      </ul>
    @endforeach
  </body>
</html>

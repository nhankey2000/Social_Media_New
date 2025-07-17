<h2>Danh sách ID được kích hoạt</h2>
<form method="POST" action="/keys">
    @csrf
    <input name="hardware_id" placeholder="Nhập ID..." />
    <button type="submit">Thêm</button>
</form>

<ul>
    @foreach ($keys as $key)
        <li>
            {{ $key->hardware_id }}
            <form method="POST" action="/keys/{{ $key->id }}">
                @csrf
                @method('DELETE')
                <button>Xoá</button>
            </form>
        </li>
    @endforeach
</ul>

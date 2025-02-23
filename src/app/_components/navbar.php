<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li><a>Item 1</a></li>
                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div>
        <a href="/" class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <div class="navbar-center hidden md:flex z-10">
        <ul class="menu menu-horizontal px-1">
            <li><a class="<?= $pathname == '/users' ? 'bg-blue-500' : '' ?>" href="/users">Users</a></li>
            <li>
                <details>
                    <summary>Public</summary>
                    <ul class="p-2">
                        <li><a class="<?= $pathname == '/customers' ? 'bg-blue-500' : '' ?>" href="/customers">Customers</a></li>
                        <li><a class="<?= $pathname == '/adds' ? 'bg-blue-500' : '' ?>" href="/adds">Adds</a></li>
                    </ul>
                </details>
            </li>
            <li><a>Item 3</a></li>
        </ul>
    </div>
    <div class="navbar-end">
        <label class="cursor-pointer grid place-items-center">
            <input id="themeName" type="checkbox" value="dark" class="toggle theme-controller bg-base-content row-start-1 col-start-1 col-span-2" />
            <svg class="col-start-1 row-start-1 stroke-base-100 fill-base-100" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5" />
                <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" />
            </svg>
            <svg class="col-start-2 row-start-1 stroke-base-100 fill-base-100" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </label>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let themeName = document.getElementById('themeName');
        if (store.state.themeName) {
            themeName.checked = store.state.themeName === 'dark';
        }

        themeName.addEventListener('change', function() {
            const themeName = this.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', themeName);
            store.setState({
                themeName
            }, true);
        });
    });
</script>
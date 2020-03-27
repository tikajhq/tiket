<li><a href="<?= BASE_URL ?>user/dashboard"> <i class="fa fa-home"></i>Dashboard</a></li>

<li><a href="#ticketsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list"></i>Tickets </a>
    <ul id="ticketsDropdown" class="collapse list-unstyled ">
        <li><a href="<?= BASE_URL ?>tickets/create_new">New Ticket </a></li>
        <li><a href="<?= BASE_URL ?>tickets/assigned_to_me">Assigned to me</a></li>
        <li><a href="<?= BASE_URL ?>tickets/my_tickets"></i>My Tickets </a></li>
        <li><a href="<?= BASE_URL ?>tickets/cc_to_me">Following</a></li>
    </ul>
</li>
<li><a href="<?= BASE_URL ?>user/profile"> <i class="fa fa-user"></i>Profile </a></li>
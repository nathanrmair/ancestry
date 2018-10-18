<div class="container-fluid" id="membership-container">
    <div class="col-lg-5 col-lg-offset-1 current-membership">
        <div class="container-fluid membership-card">
            <div class="membership-title">Guest user</div>
            <i class="fa fa-5x fa-user membership-avatar" id="arrow-icon" aria-hidden="true"></i>
            <ul class="fa-ul membership-list">
                <li><i class="fa-li fa fa-check"></i>Create own profile</li>
                <li><i class="fa-li fa fa-check"></i>Store all ancestor information in one easy to use location
                </li>
                <li><i class="fa-li fa fa-check"></i>Upload pictures and documents on ancestors</li>
                <li><i class="fa-li fa fa-check"></i>Perform searches to find which providers have information
                    on your ancestors
                </li>
                <li><i class="fa-li fa fa-check"></i>Upload pictures and documents on ancestors</li>
                <li><i class="fa-li fa fa-check"></i>View providers' profile pages to find out more information
                    about them
                </li>
                <li><i class="fa-li fa fa-times"></i>Message providers you are interested in to see if they have
                    any information about your ancestors
                </li>
                <li><i class="fa-li fa fa-times"></i>Receive information about what providers hold for your ancestors
                </li>
            </ul>
            <div class="membership-price">Free</div>
        </div>
    </div>

    {{--Other card--}}
    <div class="col-lg-5 col-lg-offset-1 current-membership">

        <div class="container-fluid membership-card">
            <div class="membership-title">Member</div>
            <i class="fa fa-5x fa-star membership-avatar" id="arrow-icon" aria-hidden="true"></i>
            <ul class="fa-ul membership-list">
                <li><i class="fa-li fa fa-check"></i>Create own profile</li>
                <li><i class="fa-li fa fa-check"></i>Store all ancestor information in one easy to use location
                </li>
                <li><i class="fa-li fa fa-check"></i>Upload pictures and documents on ancestors</li>
                <li><i class="fa-li fa fa-check"></i>Perform searches to find which providers have information
                    on your ancestors
                </li>
                <li><i class="fa-li fa fa-check"></i>Upload pictures and documents on ancestors</li>
                <li><i class="fa-li fa fa-check"></i>View providers' profile pages to find out more information
                    about them
                </li>
                <li><i class="fa-li fa fa-check"></i>Message providers you are interested in to see if they have
                    any information about your ancestors
                </li>
                <li><i class="fa-li fa fa-check"></i>Receive information about what providers hold for your ancestors
                </li>
            </ul>
            <a href="{{url('/profile/upgrade/')}}" id="upgrade-a"><div class="membership-price">Upgrade now for free</div></a>

        </div>
    </div>
</div>

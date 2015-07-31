<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('view a customer recent reviews');

// Log in Test User
$I->login('demo@demo.com', 'monday');

$I->amOnPage('/account/reviews');
$I->see('Recent Reviews', 'h2');
$I->seeElement('.breadcrumb');

//--------------------------------------------------------------------
// Expect recent reviews list to be empty
//--------------------------------------------------------------------
$I->expect('the reviews list to be empty');
$I->see('Sale ID', 'table thead th');
$I->see('Sale Type', 'table thead th');
$I->see('Restaurant', 'table thead th');
$I->see('Rating', 'table thead th');
$I->see('Date', 'table thead th');
$I->see('There are no added review(s).', 'table td');
$I->see('Displaying');  // ensure pagination is present.

//--------------------------------------------------------------------
// Expect back link work.
//--------------------------------------------------------------------
$I->expect('the back button to be linked');
$I->click('Back');
$I->see('My Account', 'h2');

$I->wantTo('add a customer reviews on order #200015.');
$I->amOnPage('/account/reviews/add/order/20015/11');
$I->see('Write Review', 'h2');

//--------------------------------------------------------------------
// Expect Error due review text being too long
//--------------------------------------------------------------------
$I->expect('error returned due to exceeding review text character limit of (1028)');
$I->seeElement('input', ['id' => 'location']);
$I->dontSeeElement('input', ['name' => 'location_id']);
$I->seeElement('input', ['id' => 'customer']);
$I->dontSeeElement('input', ['name' => 'customer_id']);
$I->click('div[data-score-name="rating[quality]"] i[data-alt="4"]');
$I->click('div[data-score-name="rating[delivery]"] i[data-alt="3"]');
$I->click('div[data-score-name="rating[service]"] i[data-alt="5"]');
$I->fillField('review_text', 'Integer lacinia metus purus, ac vestibulum nibh tincidunt nec. Aliquam nec gravida mi. Pellentesque blandit neque at orci tincidunt, porttitor condimentum quam pretium.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed magna vitae quam lacinia finibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin enim tellus, sollicitudin sit amet libero ut, varius ornare tellus. Morbi imperdiet sed tortor quis ultricies. Proin vehicula eleifend felis, id lobortis ipsum pretium et. Morbi ullamcorper dolor vel sapien tincidunt laoreet. Pellentesque sit amet ligula augue. Aenean pulvinar dapibus tortor consectetur ullamcorper. Nullam ultricies ac nulla a elementum. Aliquam egestas purus ipsum, eu faucibus dolor mattis eget. Cras eu sollicitudin leo. Nunc ac dolor gravida, consectetur velit id, condimentum nibh. Etiam pulvinar a lacus a sodales. Mauris convallis neque sed sapien varius ultrices. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;  Donec ut leo eget nisl blandit congue. Sed vehicula est vitae magna tincidunt, eget consectetur quam ultricies. Phasellus cursus turpis in condimentum mattis. Duis malesuada nisi ipsum, id fermentum dolor porttitor vel. Cras rutrum eros et lectus congue bibendum. Proin mauris magna, malesuada in mauris sit amet, malesuada fermentum ligula. Nullam purus lacus, dictum sit amet libero non, bibendum finibus leo. Mauris scelerisque efficitur purus, eget blandit augue ultrices vel. In in purus ut elit feugiat volutpat. Sed a eleifend orci, sit amet hendrerit justo. Quisque eu est eu orci convallis egestas.  Vivamus vehicula tristique massa nec ultricies. Nulla facilisis scelerisque eros, non commodo turpis. Proin vitae enim in lorem commodo fringilla sed eget felis. Etiam posuere risus in urna egestas, eu faucibus nisl scelerisque. Proin ut justo eget arcu egestas luctus. Nulla lacus lacus, eleifend et luctus et, semper sit amet orci. Aenean sodales iaculis nunc, imperdiet ornare ipsum volutpat et. Fusce sed purus metus. Sed at finibus sapien. Aliquam auctor non metus et vestibulum. Quisque a nulla non magna gravida rhoncus ac ut nulla.  Integer lacinia metus purus, ac vestibulum nibh tincidunt nec. Aliquam nec gravida mi. Pellentesque blandit neque at orci tincidunt, porttitor condimentum quam pretium. Donec iaculis scelerisque molestie. Etiam dignissim laoreet dui nec imperdiet. Morbi non lectus vel neque faucibus iaculis. Fusce sit amet dui libero. Etiam odio mauris, tristique in augue nec, auctor sagittis justo.  Proin eget porttitor odio. Aenean egestas risus et lobortis aliquam. Ut vestibulum nulla vitae magna vulputate maximus. Nulla bibendum nunc diam, eu interdum ligula pellentesque id. Aenean posuere bibendum dictum. In gravida eros et metus maximus convallis. Aenean bibendum, ex vel porttitor luctus, ligula purus sollicitudin nulla, et gravida elit sem id sapien. Aliquam lacinia diam neque. ');
$I->click('form button[type=submit]');
$I->dontSeeElement('.alert-success');
$I->seeElement('.text-danger');

//--------------------------------------------------------------------
// Successfully send customer review without error
//--------------------------------------------------------------------
$I->expect('customer review to be successfully sent');
$I->click('div[data-score-name="rating[quality]"] i[data-alt="4"]');
$I->click('div[data-score-name="rating[delivery]"] i[data-alt="3"]');
$I->click('div[data-score-name="rating[service]"] i[data-alt="5"]');
$I->fillField('review_text', 'Integer lacinia metus purus, ac vestibulum nibh tincidunt nec. Aliquam nec gravida mi. Pellentesque blandit neque at orci tincidunt, porttitor condimentum quam pretium.');
$I->click('form button[type=submit]');
$I->dontSeeElement('.text-danger');
$I->see('Review sent successfully, it will be visible once approved.', '.alert-success');


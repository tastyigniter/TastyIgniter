var AddressTab = {

    init: function () {
        $(document).render(function () {
            var $addressTabs = $('[data-control="address-tabs"]')
            $addressTabs.on('click', '[data-add-address]', function (event) {
                AddressTab.add(event)
            }).on('click', '[data-remove-address]', function (event) {
                AddressTab.remove(event)
            })
        })
    },

    add: function () {
        var $container = $('[data-control="address-tabs"]'),
            $template = $container.find('[data-address-template]'),
            lastCounter = parseInt($container.attr('data-last-counter'))+1,
            $newTemplate = $template.clone(),
            $appendTo = $('[data-append-to]'),
            findRow = new RegExp('\\%\\%index\\%\\%', "g")

        $appendTo.append($newTemplate.get(0).innerHTML.replace(findRow, lastCounter));

        $('[data-add-address]').parent().before('<li class="nav-item"><a class="nav-link" href="#'
            + $appendTo.find('.tab-pane:last-child').attr('id')
            + '" data-toggle="tab"> Address '
        + lastCounter + '&nbsp;&nbsp;<i class="fa fa-times-circle" data-remove-address></i></a></li>');

        $container.attr('data-last-counter', lastCounter)
    },

    remove: function (event) {
        var $el = $(event.target)

        if (confirm($el.data('confirm'))) {
            $el.parents('li').remove()
            $($el.parents('a').attr('href')).remove()
        }
    }
}

AddressTab.init()

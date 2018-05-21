<div class="col-xs-12 col-sm-6">
    <div class="panel panel-theme">
        <div class="theme-thumb">
            <img class="img-responsive" src="{{icon}}" alt="{{name}}">
        </div>
        <h5 class="theme-title">{{name}} <span class="small">by {{author}}</span></h5>
        <p class="theme-description">{{{description}}}</p>

        <div class="theme-action">
            <a
                type="button"
                class="btn btn-default"
                target="_blank"
                href="{{homepage}}"
            >Demo</a>

            <button
                type="button"
                class="btn btn-primary"
                data-install-control="install-theme"
                data-theme-code="{{code}}"
            >Install</button>
        </div>
    </div>
</div>
<div class="alert alert-danger">
    <h4>System Requirements Check Failed</h4>
    <p>
        {{#message}}{{{message}}}{{/message}}
        {{^message}}Your system does not meet the minimum requirements for the installation.{{/message}}
    </p>
    <p>
        Please see <a href="//docs.tastyigniter.com" target="_blank">the documentation</a> for more information.
    </p>
    <p><a data-install-control="retry-check" class="btn btn-default btn-sm">Retry Check</a></p>
    <small>Error message code: {{code}}</small>
</div>

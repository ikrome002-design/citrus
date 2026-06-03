<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>jQuery Accordion Wizard Form Example</title>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.3/materia/bootstrap.min.css">
    <style>
        body {
            background-color: #fafafa;
        }

        .container {
            margin: 150px auto;
        }

        div[data-acc-content] {
            display: none;
        }

        div[data-acc-step]:not(.open) {
            background: #f2f2f2;
        }

        div[data-acc-step]:not(.open) h5 {
            color: #777;
        }

        div[data-acc-step]:not(.open) .badge-primary {
            background: #ccc;
        }
    </style>
</head>

<body>
    <div id="jquery-script-menu">
        <div class="jquery-script-center">
            <ul>
                <li><a href="https://www.jqueryscript.net/form/Accordion-Wizard-Form.html">Download This Plugin</a></li>
                <li><a href="https://www.jqueryscript.net/">Back To jQueryScript.Net</a></li>
            </ul>
            <div class="jquery-script-ads">
                <script type="text/javascript">
                    <!--
                    google_ad_client = "ca-pub-2783044520727903";
                    /* jQuery_demo */
                    google_ad_slot = "2780937993";
                    google_ad_width = 728;
                    google_ad_height = 90;
                    //
                    -->
                </script>
                <script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
            </div>
            <div class="jquery-script-clear"></div>
        </div>
    </div>
    <div class="container">
        <h1>jQuery Accordion Wizard Form Example</h1>
        <form id="form">

            <div class="list-group">

                <div class="list-group-item py-3" data-acc-step>
                    <h5 class="mb-0" data-acc-title>Name &amp; Email</h5>
                    <div data-acc-content>
                        <div class="my-3">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" name="email" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group-item py-3" data-acc-step>
                    <h5 class="mb-0" data-acc-title>Contact</h5>
                    <div data-acc-content>
                        <div class="my-3">
                            <div class="form-group">
                                <label>Telephone:</label>
                                <input type="text" name="telephone" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label>Mobile:</label>
                                <input type="text" name="mobile" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group-item py-3" data-acc-step>
                    <h5 class="mb-0" data-acc-title>Payment</h5>
                    <div data-acc-content>
                        <div class="my-3">
                            <div class="form-group">
                                <label>Credit card:</label>
                                <input type="text" name="card" class="form-control">
                            </div>
                            <div class="form-group form-row">
                                <div class="col-sm-4">
                                    <label>Expiry:</label>
                                    <input type="text" name="expiry" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <label>CVV:</label>
                                    <input type="text" name="cvv" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </form>
    </div>
    <script src="/assets/js/vendor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script>
        ! function(a, t, e, s) {
            "use strict";
            var n = "accWizard",
                i = {
                    start: 1,
                    mode: "wizard",
                    enableScrolling: !0,
                    scrollPadding: 5,
                    autoButtons: !0,
                    autoButtonsNextClass: null,
                    autoButtonsPrevClass: null,
                    autoButtonsShowSubmit: !0,
                    autoButtonsSubmitText: "Submit",
                    stepNumbers: !0,
                    stepNumberClass: "",
                    beforeNextStep: function(t) {
                        return !0
                    },
                    onSubmit: function(t) {
                        return !0
                    }
                };

            function c(t, e) {
                this.element = t, this.settings = a.extend({}, i, e), this._defaults = i, this._name = n, this.init()
            }
            a.extend(c.prototype, {
                init: function() {
                    var n = this;
                    this.$steps = a("[data-acc-step]"), this.stepHeight = a("[data-acc-step]").eq(0)
                        .outerHeight(), this.settings.stepNumbers && this.$steps.each(function(t, e) {
                            a("[data-acc-title]", e).prepend('<span class="acc-step-number ' + n.settings
                                .stepNumberClass + '">' + (t + 1) + "</span> ")
                        }), this.settings.autoButtons && this.$steps.each(function(t, e) {
                            var s = a("[data-acc-content]", e);
                            0 < t && s.append('<a href="#" class="' + n.settings.autoButtonsPrevClass +
                                    '" data-acc-btn-prev>Back</a>'), t < n.$steps.length - 1 ? s.append(
                                    '<a href="#" class="' + n.settings.autoButtonsNextClass +
                                    '" data-acc-btn-next>Next</a>') : n.settings.autoButtonsShowSubmit && s
                                .append('<input type="submit" class="' + n.settings.autoButtonsNextClass +
                                    '" value="' + n.settings.autoButtonsSubmitText + '">')
                        }), this.currentIndex = this.settings.start - 1, "wizard" == this.settings.mode ? (this
                            .activateStep(this.currentIndex, !0), a("[data-acc-btn-next]").on("click",
                                function() {
                                    n.settings.beforeNextStep(n.currentIndex + 1) && n.activateStep(n
                                        .currentIndex + 1)
                                }), a("[data-acc-btn-prev]").on("click", function() {
                                n.activateStep(n.currentIndex - 1)
                            })) : "edit" == this.settings.mode && (this.activateAllSteps(), a(
                            "[data-acc-btn-next]").hide(), a("[data-acc-btn-prev]").hide()), a(this.element).on(
                            "submit",
                            function(t) {
                                n.settings.onSubmit() || t.preventDefault()
                            })
                },
                deactivateStep: function(t, e) {
                    this.$steps.eq(t).removeClass("active")
                },
                activateStep: function(t, e) {
                    this.$steps.removeClass("open");
                    var s = t > this.currentIndex ? this.stepHeight : -this.stepHeight;
                    !e && this.settings.enableScrolling && a("html").animate({
                        scrollTop: this.$steps.eq(this.currentIndex).offset().top + (s - this.settings
                            .scrollPadding)
                    }, 500), a("[data-acc-content]", this.element).slideUp(), this.$steps.eq(t).addClass(
                        "open").find("[data-acc-content]").slideDown(), this.currentIndex = t
                },
                activateNextStep: function() {
                    this.activateStep(this.currentIndex + 1)
                },
                activateAllSteps: function() {
                    this.$steps.addClass("open"), a("[data-acc-content]", this.element).show()
                }
            }), a.fn[n] = function(t) {
                return this.each(function() {
                    a.data(this, "plugin_" + n) || a.data(this, "plugin_" + n, new c(this, t))
                })
            }
        }(jQuery, window, document);
    </script>
    <script>
        var options = {
            mode: 'wizard',
            autoButtonsNextClass: 'btn btn-primary float-right',
            autoButtonsPrevClass: 'btn btn-light',
            stepNumberClass: 'badge badge-pill badge-primary mr-1',
            onSubmit: function() {
                alert('Form submitted!');
                return true;
            }
        }

        $(function() {

            $("#form").accWizard(options);

        });
    </script>
</body>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
            '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
</script>

</html>

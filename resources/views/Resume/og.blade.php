<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{$name . ' - Resume - ' . date('M Y')}}</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Custom Styling  -->
        @vite(['resources/css/resume/og/style.css'])
        <!-- Google font  -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap" rel="stylesheet">
    </head>
    <body>
    <div style="
        background: url({{ $cover_photo }}) !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        " class="resume-top">
        <div style="background: rgba(33,37,41,60%); border-radius: 15px">
            <header id="info">
                <h1>
                    <img style="border-radius: 100px" height="100px" src="{{ $profile_photo }}">
                    <span class="name">
                        {{ $name }}<br>
                        <span class="resume-socials">
                            @foreach($socials as $social)
                                <a href="{{ $social['url'] }}"><img width="auto" height="30px" src="{{ $social['logo'] }}"></a>
                            @endforeach
                        </span>
                    </span>
                </h1>
                <span class="contact-info">
                    <table>
                        <td><i class="fa-solid fa-location-dot" style="color: crimson;"></i></td>
                        <td style="vertical-align: top;">{{ $address }}</td>
                        <td><i class="fa-solid fa-phone-volume" style="color: limegreen;"></i></td>
                        <td style="vertical-align: top;">{{ $mobile }}</td>
                        <td><i class="fa-solid fa-envelope" style="color: sandybrown;"></i></td>
                        <td style="vertical-align: top;"><a href="mailto:{{ $email }}" class="text-white ml-2">{{ $email }}</a></td>
                    </table>
                </span>
                <section id="statement">
                    <h2>About Me</h2>
                    <p style="background: rgba(33,37,41,25%); border-radius: 15px; padding: 15px">{{ $introduction }}</p>
                </section>
            </header>
        </div>
    </div>
    <section id="skills">
        <h2 style="text-align: center; font-size: 30px">Skills</h2>
        <section>
            <div style="background: #393C3F; border-radius: 15px; padding: 20px; margin: 0px -20px 0 -20px;">
                <div style="display: flex; flex-wrap: wrap;">
                    @foreach($skills as $skill)
                        <a @if(!empty($skill['url'])) href="{{ $skill['url'] }}" @endif style="margin: 5px">
                            <div style="display: flex;background: #434649; border-radius: 15px; padding: 3px 5px 0 7px; vertical-align: middle;">
                                <b style="vertical-align: middle; line-height: 2;">{{ $skill['name'] }}</b>
                                @if(!empty($skill['icon']))
                                    <div style="display: inline-block">
                                        <img alt="{{ $skill['name'] }} icon image" src="{{ $skill['icon'] }}" width="auto" height="26" style="vertical-align: middle; padding-left: 5px; margin-top: 2px;">
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </section>
    <section id="employment">
        @foreach($experiences as $type => $experience_type)
        <h2 style="text-align: center; font-size: 30px">{{ $type }}</h2>
        <section>
            <div style="background: #393C3F; border-radius: 15px; padding: 20px; padding-bottom: 0; margin: 0px -20px 0 -20px; overflow: visible">
                @foreach($experience_type as $experience)
                    <div style="padding: 20px 20px 0;margin: 0px -20px 0 -20px; overflow: visible">
                        <table>
                            <tr>
                                <td class="no-space" style="width: 200px !important;"><img height="auto" width="auto" style=" max-width: 200px !important; max-height: 50px !important" src="{{ $experience['entity_logo'] }}"></td>
                                <td class="no-space" style="text-align: right; vertical-align: bottom; font-size: 24px; width: fit-content"><b>{{ $experience['title'] }}</b></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td class="no-space" style="vertical-align: top; font-size: 20px;"><span><i>{{ $experience['entity_name'] }}</i></span></td>
{{--                                <td class="no-space" style="vertical-align: top; font-size: 20px;"><span><i>{{ $experience['entity_name'] }}</i></span></td>--}}
                                <td class="no-space" style="text-align: right; font-size: 20px; width: 280px">{{ $experience['date_started'] }} - {{ $experience['date_ended'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ $experience['description'] }}</td>
                            </tr>
                        </table>
                    </div>
                    @if(!empty($experience['milestones']))
                        <div style="background: #434649; padding: 20px 20px 0; margin: 0px -20px 0 -20px; @if ($loop->last)border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;@endif">
                            <table>
                                @foreach($experience['milestones'] as $milestone)
                                <tr>
                                    @if(!empty($milestone['image']))
                                        <td class="no-space" style="vertical-align: top; font-size: 16px"><span><u>{{ $milestone['title'] }}</u></span></td>
                                        <td class="no-space" style="text-align: right; width: 200px"><img height="auto" width="auto" style="max-width: 200px !important; max-height: 60px !important"  src="{{ $milestone['image'] }}"></td>
                                    @else
                                        <td class="no-space" style="vertical-align: top; font-size: 16px" colspan="2"><span><u>{{ $milestone['title'] }}</u></span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="2">{!!$milestone['description']!!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
        @endforeach
    </section>
    <br><br><br>
    <footer class="bg-dark text-white-50 text-center mt-5 p-2" style="display:block; position: absolute !important; bottom: -5px !important; width: 100% !important; margin-left: -35px !important; text-align: center !important;">
        <table>
            <tr>
                <td style="font-size: 18px !important;"><span style="vertical-align: text-before-edge">&copy; {{ date("Y") }} {{ $name }} - <a class="text-white-50" href="https://github.com" target="_blank">Dynamically Generated HTML CV</a> | Made with</span>
    {{--            </td>--}}
    {{--            <td>--}}
                    <a href="https://en.wikipedia.org/wiki/HTML5" style="vertical-align: middle">
                        <img style="padding: 5px 5px 5px 5px;" src="https://upload.wikimedia.org/wikipedia/commons/6/61/HTML5_logo_and_wordmark.svg" height="30px" width="auto">
                    </a>
                    <a href="https://en.wikipedia.org/wiki/CSS" style="vertical-align: middle">
                        <img style="padding: 5px 5px 5px 5px;" src="https://upload.wikimedia.org/wikipedia/commons/d/d5/CSS3_logo_and_wordmark.svg" height="30px" width="auto">
                    </a>
                    <a href="https://laravel.com/docs/10.x/blade" style="vertical-align: middle">
                        <img style="padding: 5px 5px 5px 5px;" src="https://cdn.cdnlogo.com/logos/b/87/blade-ui-kit.svg" height="30px" width="auto">
                    </a>
                    <a href="https://www.pdfreactor.com/" style="vertical-align: middle">
                        <img style="padding: 5px 5px 5px 5px;" src="https://cdn.pdfreactor.com/wp-content/uploads/images/logos/pr-logo-disc.png" height="30px" width="auto">
                    </a>
                    <a href="https://laravel.com/" style="vertical-align: middle">
                        <img style="padding: 5px 5px 5px 5px;" src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" height="30px" width="auto">
                    </a>
                </td>
            </tr>
        </table>
    </footer>
    </body>
</html>

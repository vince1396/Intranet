    <section>
        <div id="particles-js">
          <canvas class="particles-js-canvas-el"  style="width: 100%; height: 100%;"></canvas>
        </div>    
        <div class="l-404-container">
            <div class="l-404-text">
                <h1 class="title-404"> ERREUR 404 </h1>
                <a class="link-404" href="index.php" ><h2 >Retour à l'accueil</a></h2>
            </div>
        </div>
    </section>
    
    

    <script src="vendor/jquery/jquery-3.1.1.min.js"></script> 
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        
particlesJS('particles-js', {
    'particles': {
        'number': {
            'value': 80,
            'density': {
                'enable': true,
                'value_area': 800
            }
        },
        'color': { 'value': '#ffffff' },
        'shape': {
            'type': 'circle',
            'stroke': {
                'width': 0,
                'color': '#000000'
            },
            'polygon': { 'nb_sides': 5 },
            'image': {
                'src': 'img/github.svg',
                'width': 100,
                'height': 100
            }
        },
        'opacity': {
            'value': 0.5,
            'random': false,
            'anim': {
                'enable': false,
                'speed': 1,
                'opacity_min': 0.5,
                'sync': false
            }
        },
        'size': {
            'value': 3,
            'random': true,
            'anim': {
                'enable': false,
                'speed': 40,
                'size_min': 0.1,
                'sync': false
            }
        },
        'line_linked': {
            'enable': true,
            'distance': 150,
            'color': '#ffffff',
            'opacity': 0.4,
            'width': 1
        },
        'move': {
            'enable': true,
            'speed': 6,
            'direction': 'none',
            'random': false,
            'straight': false,
            'out_mode': 'out',
            'bounce': false,
            'attract': {
                'enable': false,
                'rotateX': 600,
                'rotateY': 1200
            }
        }
    },
    'interactivity': {
        'detect_on': 'canvas',
        'events': {
            'onhover': {
                'enable': true,
                'mode': 'grab'
            },
            'onclick': {
                'enable': true,
                'mode': 'push'
            },
            'resize': true
        },
        'modes': {
            'grab': {
                'distance': 140,
                'line_linked': { 'opacity': 1 }
            },
            'bubble': {
                'distance': 400,
                'size': 40,
                'duration': 2,
                'opacity': 8,
                'speed': 3
            },
            'repulse': {
                'distance': 200,
                'duration': 0.4
            },
            'push': { 'particles_nb': 4 },
            'remove': { 'particles_nb': 2 }
        }
    },
    'retina_detect': true
});
    </script>


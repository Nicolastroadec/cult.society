
const array = [];

const cards = document.querySelectorAll('.w3-card-4');

cards.forEach(card => {
    const obj = {
        h5: '',
        authors: '',
        authorLink: '',
        authorsQuality: '',
        videoLink: '',
        videoType: '',
        challengeType: '',
        thematiques: [],
        tags: [],
    };

    obj.h5 = card.querySelector('h5').innerText.replace(/\n/g, '');

    if (card.classList.contains('Challenge1') || card.classList.contains('Challenge2') || card.classList.contains('Challenge3')) {
        obj.videoType = 'challenge';
    }
    if (card.classList.contains('Fundamentals')) {
        obj.videoType = 'fundamentals';
    }

    if (card.classList.contains('Challenge1')) {
        obj.challengeType = 'challenge-1';
    }

    if (card.classList.contains('Challenge2')) {
        obj.challengeType = 'challenge-2';
    }

    if (card.classList.contains('Challenge3')) {
        obj.challengeType = 'challenge-3';
    }

    const thematiques = ['Climate', 'Agriculture', 'Satellite', 'Ecology', 'Biodiversity', 'Evolution', 'Water', 'Biogeochemistry', 'Adaptation', 'Land', 'Production', 'Energy', 'Pollution', 'Environment', 'Crop', 'Carbon', 'GHG', 'Forest', 'Economics', 'Breeding', 'Plant'];

    thematiques.forEach(thematique => {
        if (card.classList.contains(thematique)) {
            obj.thematiques.push(thematique);
        }
    })

    const h6 = card.querySelector('h6');
    const link = h6.querySelector('a');


    if (link) {
        obj.authors = link.innerText;
        obj.authorLink = link.href;
    }

    obj.authorsQuality = h6.querySelector('em')?.innerText;


    obj.videoLink = card.querySelector('iframe')?.getAttribute('src');

    ['.tag1', '.tag2', '.tag3', '.tag4'].forEach(selector => {
        const tag = card.querySelector(selector);
        if (tag) {
            tag.querySelectorAll('p').forEach(p => {
                const cleaned = p.innerText
                    .replace(/#/g, '')         // enlève tous les #
                    .trim()                    // supprime les espaces autour
                    .replace(/\s+/g, ' ');     // remplace plusieurs espaces par un seul

                if (cleaned.length > 0) {
                    obj.tags.push(cleaned);
                }
            });
        }
    });




    array.push(obj);
})




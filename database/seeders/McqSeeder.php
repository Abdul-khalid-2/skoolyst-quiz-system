<?php
declare(strict_types=1);

return function (PDO $pdo): void {
    $questions = [
        [
            'subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'easy',
            'question' => 'Which organelle is known as the powerhouse of the cell?',
            'explanation' => 'Mitochondria generate ATP through cellular respiration, earning them the nickname "powerhouse of the cell."',
            'options' => [['A', 'Nucleus', false], ['B', 'Mitochondria', true], ['C', 'Ribosome', false], ['D', 'Golgi apparatus', false]],
        ],
        [
            'subject' => 'chemistry', 'topic' => 'atmospheric-chemistry', 'difficulty' => 'medium',
            'question' => "What is the most abundant gas in Earth's atmosphere?",
            'explanation' => 'Nitrogen makes up about 78% of the atmosphere by volume.',
            'options' => [['A', 'Nitrogen', true], ['B', 'Oxygen', false], ['C', 'Carbon Dioxide', false], ['D', 'Argon', false]],
        ],
        [
            'subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'hard',
            'question' => 'Which enzyme breaks down starch into maltose in the digestive system?',
            'explanation' => 'Amylase, found in saliva and pancreatic secretions, hydrolyzes starch into maltose.',
            'options' => [['A', 'Amylase', true], ['B', 'Lipase', false], ['C', 'Pepsin', false], ['D', 'Trypsin', false]],
        ],
        [
            'subject' => 'mathematics', 'topic' => 'calculus', 'difficulty' => 'medium',
            'question' => 'What is the derivative of x² with respect to x?',
            'explanation' => 'Using the power rule, d/dx(x^n) = n·x^(n-1), so the derivative of x² is 2x.',
            'options' => [['A', 'x', false], ['B', '2x', true], ['C', 'x²', false], ['D', '2', false]],
        ],
        [
            'subject' => 'physics', 'topic' => 'electricity', 'difficulty' => 'medium',
            'question' => 'What is the SI unit of electric current?',
            'explanation' => 'The ampere (A) is the SI base unit of electric current.',
            'options' => [['A', 'Volt', false], ['B', 'Ampere', true], ['C', 'Ohm', false], ['D', 'Watt', false]],
        ],
        [
            'subject' => 'general-knowledge', 'topic' => 'geography', 'difficulty' => 'easy',
            'question' => 'Which planet is known as the Red Planet?',
            'explanation' => 'Mars appears red due to iron oxide (rust) on its surface.',
            'options' => [['A', 'Venus', false], ['B', 'Mars', true], ['C', 'Jupiter', false], ['D', 'Saturn', false]],
        ],

        // ===================== BIOLOGY =====================
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'easy', 'question' => 'What is the basic structural and functional unit of life?', 'explanation' => 'The cell is the smallest unit capable of independent life functions.', 'options' => [['A', 'Cell', true], ['B', 'Tissue', false], ['C', 'Organ', false], ['D', 'Organelle', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'easy', 'question' => 'Which part of the cell contains genetic material (DNA)?', 'explanation' => 'The nucleus houses the cell\'s chromosomal DNA.', 'options' => [['A', 'Cytoplasm', false], ['B', 'Nucleus', true], ['C', 'Ribosome', false], ['D', 'Lysosome', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'medium', 'question' => 'Which organelle is responsible for protein synthesis?', 'explanation' => 'Ribosomes translate mRNA into proteins.', 'options' => [['A', 'Ribosome', true], ['B', 'Golgi apparatus', false], ['C', 'Lysosome', false], ['D', 'Vacuole', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'hard', 'question' => 'What is the term for programmed cell death?', 'explanation' => 'Apoptosis is a regulated process of cell self-destruction.', 'options' => [['A', 'Mitosis', false], ['B', 'Apoptosis', true], ['C', 'Meiosis', false], ['D', 'Necrosis', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'easy', 'question' => 'Which structure controls what enters and leaves the cell?', 'explanation' => 'The cell membrane is selectively permeable, regulating the movement of substances.', 'options' => [['A', 'Cell wall', false], ['B', 'Cell membrane', true], ['C', 'Nucleolus', false], ['D', 'Cytoskeleton', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'medium', 'question' => 'Plant cells differ from animal cells mainly because plant cells have:', 'explanation' => 'Plant cells have a rigid cell wall and chloroplasts, which animal cells lack.', 'options' => [['A', 'Cell wall and chloroplasts', true], ['B', 'Mitochondria only', false], ['C', 'Ribosomes only', false], ['D', 'Nucleus only', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'medium', 'question' => 'Which cell organelle is involved in packaging and modifying proteins for secretion?', 'explanation' => 'The Golgi apparatus modifies, sorts, and packages proteins for secretion or use within the cell.', 'options' => [['A', 'Golgi apparatus', true], ['B', 'Nucleus', false], ['C', 'Mitochondria', false], ['D', 'Peroxisome', false]]],
        ['subject' => 'biology', 'topic' => 'cell-biology', 'difficulty' => 'medium', 'question' => 'What type of cell lacks a true nucleus?', 'explanation' => 'Prokaryotic cells, such as bacteria, lack a membrane-bound nucleus.', 'options' => [['A', 'Eukaryotic cell', false], ['B', 'Prokaryotic cell', true], ['C', 'Plant cell', false], ['D', 'Animal cell', false]]],

        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'easy', 'question' => 'Who is known as the father of genetics?', 'explanation' => 'Gregor Mendel\'s pea plant experiments laid the foundation for modern genetics.', 'options' => [['A', 'Charles Darwin', false], ['B', 'Gregor Mendel', true], ['C', 'James Watson', false], ['D', 'Francis Crick', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'easy', 'question' => 'DNA stands for:', 'explanation' => 'DNA is short for deoxyribonucleic acid, the molecule that carries genetic information.', 'options' => [['A', 'Deoxyribonucleic acid', true], ['B', 'Denatured nucleic acid', false], ['C', 'Dual nucleic acid', false], ['D', 'Deoxyribose nuclear acid', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'medium', 'question' => 'A person with genotype Aa is called:', 'explanation' => 'Heterozygous describes an organism with two different alleles for a gene.', 'options' => [['A', 'Homozygous', false], ['B', 'Heterozygous', true], ['C', 'Hemizygous', false], ['D', 'Homogenous', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'medium', 'question' => 'How many chromosomes are present in a normal human somatic cell?', 'explanation' => 'Human somatic cells are diploid, containing 46 chromosomes (23 pairs).', 'options' => [['A', '23', false], ['B', '46', true], ['C', '44', false], ['D', '48', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'medium', 'question' => 'The physical expression of a genetic trait is called the:', 'explanation' => 'Phenotype refers to the observable characteristics resulting from genotype and environment.', 'options' => [['A', 'Genotype', false], ['B', 'Phenotype', true], ['C', 'Allele', false], ['D', 'Locus', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'medium', 'question' => 'Which scientists discovered the double helix structure of DNA?', 'explanation' => 'James Watson and Francis Crick proposed the double helix model of DNA in 1953.', 'options' => [['A', 'Watson and Crick', true], ['B', 'Mendel and Darwin', false], ['C', 'Pasteur and Koch', false], ['D', 'Fleming and Florey', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'easy', 'question' => 'A change in the DNA sequence is called a:', 'explanation' => 'Mutations are alterations in the nucleotide sequence of DNA.', 'options' => [['A', 'Mutation', true], ['B', 'Translation', false], ['C', 'Transcription', false], ['D', 'Replication', false]]],
        ['subject' => 'biology', 'topic' => 'genetics', 'difficulty' => 'easy', 'question' => 'Sex chromosomes in human males are:', 'explanation' => 'Human males typically have one X and one Y chromosome (XY).', 'options' => [['A', 'XX', false], ['B', 'XY', true], ['C', 'YY', false], ['D', 'XO', false]]],

        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'easy', 'question' => 'Which organ pumps blood throughout the human body?', 'explanation' => 'The heart is a muscular pump that circulates blood through the body.', 'options' => [['A', 'Liver', false], ['B', 'Heart', true], ['C', 'Kidney', false], ['D', 'Lungs', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'easy', 'question' => 'The normal human body temperature is approximately:', 'explanation' => 'Normal human body temperature averages around 37°C (98.6°F).', 'options' => [['A', '37°C', true], ['B', '40°C', false], ['C', '35°C', false], ['D', '39°C', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'medium', 'question' => 'Which organ is primarily responsible for filtering blood and producing urine?', 'explanation' => 'The kidneys filter waste products from blood to form urine.', 'options' => [['A', 'Liver', false], ['B', 'Kidney', true], ['C', 'Spleen', false], ['D', 'Pancreas', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'easy', 'question' => 'The largest organ of the human body is the:', 'explanation' => 'The skin is the largest organ, covering the entire body surface.', 'options' => [['A', 'Liver', false], ['B', 'Skin', true], ['C', 'Heart', false], ['D', 'Brain', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'medium', 'question' => 'Which gland is known as the "master gland" of the endocrine system?', 'explanation' => 'The pituitary gland regulates many other endocrine glands in the body.', 'options' => [['A', 'Thyroid', false], ['B', 'Pituitary gland', true], ['C', 'Adrenal gland', false], ['D', 'Pancreas', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'medium', 'question' => 'Insulin, which regulates blood sugar, is produced by the:', 'explanation' => 'The pancreas secretes insulin from its beta cells to regulate blood glucose.', 'options' => [['A', 'Liver', false], ['B', 'Pancreas', true], ['C', 'Kidney', false], ['D', 'Spleen', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'medium', 'question' => 'The human skeletal system consists of how many bones in adults?', 'explanation' => 'The adult human skeleton typically has 206 bones.', 'options' => [['A', '206', true], ['B', '300', false], ['C', '186', false], ['D', '250', false]]],
        ['subject' => 'biology', 'topic' => 'human-physiology', 'difficulty' => 'medium', 'question' => 'Which part of the brain controls balance and coordination?', 'explanation' => 'The cerebellum is responsible for coordinating movement and maintaining balance.', 'options' => [['A', 'Cerebrum', false], ['B', 'Cerebellum', true], ['C', 'Medulla oblongata', false], ['D', 'Hypothalamus', false]]],

        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'medium', 'question' => 'Where does most digestion and absorption of nutrients occur?', 'explanation' => 'The small intestine is the main site of nutrient digestion and absorption.', 'options' => [['A', 'Stomach', false], ['B', 'Small intestine', true], ['C', 'Large intestine', false], ['D', 'Esophagus', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'medium', 'question' => 'Which organ produces bile to help digest fats?', 'explanation' => 'The liver produces bile, which is stored in the gallbladder and helps emulsify fats.', 'options' => [['A', 'Pancreas', false], ['B', 'Liver', true], ['C', 'Gallbladder', false], ['D', 'Stomach', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'medium', 'question' => 'What is the main function of the large intestine?', 'explanation' => 'The large intestine mainly absorbs water and forms solid waste.', 'options' => [['A', 'Protein digestion', false], ['B', 'Absorption of water', true], ['C', 'Fat digestion', false], ['D', 'Enzyme production', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'easy', 'question' => 'Which enzyme in the stomach helps digest proteins?', 'explanation' => 'Pepsin, activated by stomach acid, breaks down proteins into peptides.', 'options' => [['A', 'Pepsin', true], ['B', 'Amylase', false], ['C', 'Lipase', false], ['D', 'Maltase', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'easy', 'question' => 'The gallbladder stores which digestive substance?', 'explanation' => 'The gallbladder stores and concentrates bile produced by the liver.', 'options' => [['A', 'Enzymes', false], ['B', 'Bile', true], ['C', 'Acid', false], ['D', 'Mucus', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'medium', 'question' => 'Peristalsis refers to:', 'explanation' => 'Peristalsis is the wave-like muscle contraction that moves food through the digestive tract.', 'options' => [['A', 'Chemical digestion', false], ['B', 'Wave-like muscle contractions moving food', true], ['C', 'Absorption of nutrients', false], ['D', 'Enzyme secretion', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'easy', 'question' => 'Which part of the digestive system is called the "food pipe"?', 'explanation' => 'The esophagus carries food from the throat to the stomach.', 'options' => [['A', 'Trachea', false], ['B', 'Esophagus', true], ['C', 'Larynx', false], ['D', 'Pharynx', false]]],
        ['subject' => 'biology', 'topic' => 'digestive-system', 'difficulty' => 'medium', 'question' => "The stomach's highly acidic environment is mainly due to:", 'explanation' => 'Gastric glands secrete hydrochloric acid, which aids digestion and kills pathogens.', 'options' => [['A', 'Hydrochloric acid', true], ['B', 'Sulfuric acid', false], ['C', 'Acetic acid', false], ['D', 'Citric acid', false]]],

        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'easy', 'question' => 'How many chambers does the human heart have?', 'explanation' => 'The human heart has four chambers: two atria and two ventricles.', 'options' => [['A', '2', false], ['B', '4', true], ['C', '3', false], ['D', '5', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'easy', 'question' => 'Which blood vessels carry blood away from the heart?', 'explanation' => 'Arteries carry oxygenated blood away from the heart (with the exception of the pulmonary artery).', 'options' => [['A', 'Veins', false], ['B', 'Arteries', true], ['C', 'Capillaries', false], ['D', 'Venules', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'easy', 'question' => 'Which blood cells are responsible for carrying oxygen?', 'explanation' => 'Red blood cells contain hemoglobin, which binds and transports oxygen.', 'options' => [['A', 'White blood cells', false], ['B', 'Red blood cells', true], ['C', 'Platelets', false], ['D', 'Plasma cells', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'medium', 'question' => 'What is the function of platelets in the blood?', 'explanation' => 'Platelets help blood clot to stop bleeding after injury.', 'options' => [['A', 'Fighting infection', false], ['B', 'Blood clotting', true], ['C', 'Carrying oxygen', false], ['D', 'Transporting hormones', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'medium', 'question' => 'Which blood type is known as the universal donor?', 'explanation' => 'O negative blood lacks A, B, and Rh antigens, making it compatible with most recipients.', 'options' => [['A', 'AB', false], ['B', 'O negative', true], ['C', 'A positive', false], ['D', 'B negative', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'medium', 'question' => 'The pulmonary artery carries blood from the heart to the:', 'explanation' => 'The pulmonary artery carries deoxygenated blood from the right ventricle to the lungs.', 'options' => [['A', 'Kidneys', false], ['B', 'Lungs', true], ['C', 'Liver', false], ['D', 'Brain', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'hard', 'question' => 'Which chamber of the heart pumps oxygenated blood to the body?', 'explanation' => 'The left ventricle pumps oxygenated blood through the aorta to the rest of the body.', 'options' => [['A', 'Right atrium', false], ['B', 'Left ventricle', true], ['C', 'Right ventricle', false], ['D', 'Left atrium', false]]],
        ['subject' => 'biology', 'topic' => 'circulatory-system', 'difficulty' => 'easy', 'question' => 'What is the average number of times a healthy heart beats per minute at rest?', 'explanation' => 'A normal resting heart rate for adults is typically 60-100 beats per minute.', 'options' => [['A', '60-100', true], ['B', '150-180', false], ['C', '30-50', false], ['D', '200-220', false]]],

        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'easy', 'question' => 'The study of interactions between organisms and their environment is called:', 'explanation' => 'Ecology examines relationships between living organisms and their surroundings.', 'options' => [['A', 'Genetics', false], ['B', 'Ecology', true], ['C', 'Physiology', false], ['D', 'Taxonomy', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'medium', 'question' => 'A community of interacting organisms and their physical environment is called a(n):', 'explanation' => 'An ecosystem includes living organisms and the non-living environment they interact with.', 'options' => [['A', 'Population', false], ['B', 'Ecosystem', true], ['C', 'Biome', false], ['D', 'Habitat', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'easy', 'question' => 'Organisms that produce their own food using sunlight are called:', 'explanation' => 'Producers, like plants, use photosynthesis to create their own energy.', 'options' => [['A', 'Consumers', false], ['B', 'Producers', true], ['C', 'Decomposers', false], ['D', 'Predators', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'easy', 'question' => 'What is the primary source of energy for most ecosystems?', 'explanation' => 'The Sun provides the energy that drives photosynthesis and most food chains.', 'options' => [['A', 'Wind', false], ['B', 'The Sun', true], ['C', 'Water', false], ['D', 'Soil nutrients', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'medium', 'question' => 'Organisms that break down dead organic matter are called:', 'explanation' => 'Decomposers, like fungi and bacteria, recycle nutrients from dead material.', 'options' => [['A', 'Producers', false], ['B', 'Decomposers', true], ['C', 'Herbivores', false], ['D', 'Carnivores', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'easy', 'question' => 'A food chain typically begins with:', 'explanation' => 'Food chains start with producers, usually plants, which convert sunlight into energy.', 'options' => [['A', 'Carnivores', false], ['B', 'Producers/plants', true], ['C', 'Decomposers', false], ['D', 'Omnivores', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'medium', 'question' => 'The gradual and predictable change in species composition of a habitat over time is called:', 'explanation' => 'Ecological succession describes the change in a community\'s structure over time.', 'options' => [['A', 'Succession', true], ['B', 'Migration', false], ['C', 'Adaptation', false], ['D', 'Symbiosis', false]]],
        ['subject' => 'biology', 'topic' => 'ecology', 'difficulty' => 'medium', 'question' => 'A relationship where both organisms benefit is called:', 'explanation' => 'Mutualism is a symbiotic relationship benefiting both participating species.', 'options' => [['A', 'Parasitism', false], ['B', 'Mutualism', true], ['C', 'Commensalism', false], ['D', 'Predation', false]]],

        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'easy', 'question' => 'Which process do plants use to make their own food?', 'explanation' => 'Photosynthesis converts light energy, water, and carbon dioxide into glucose and oxygen.', 'options' => [['A', 'Respiration', false], ['B', 'Photosynthesis', true], ['C', 'Transpiration', false], ['D', 'Fermentation', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'easy', 'question' => 'The green pigment in plants that absorbs sunlight is called:', 'explanation' => 'Chlorophyll absorbs light energy for photosynthesis and gives plants their green color.', 'options' => [['A', 'Carotene', false], ['B', 'Chlorophyll', true], ['C', 'Xanthophyll', false], ['D', 'Anthocyanin', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'easy', 'question' => 'Which part of the plant absorbs water and minerals from the soil?', 'explanation' => 'Roots absorb water and dissolved minerals from the soil.', 'options' => [['A', 'Leaves', false], ['B', 'Roots', true], ['C', 'Stem', false], ['D', 'Flower', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'medium', 'question' => 'Photosynthesis primarily takes place in which organelle?', 'explanation' => 'Chloroplasts contain chlorophyll and are the site of photosynthesis.', 'options' => [['A', 'Mitochondria', false], ['B', 'Chloroplast', true], ['C', 'Nucleus', false], ['D', 'Vacuole', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'medium', 'question' => 'What gas do plants absorb from the atmosphere during photosynthesis?', 'explanation' => 'Plants take in carbon dioxide and release oxygen during photosynthesis.', 'options' => [['A', 'Oxygen', false], ['B', 'Carbon dioxide', true], ['C', 'Nitrogen', false], ['D', 'Hydrogen', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'medium', 'question' => 'The loss of water vapor from plant leaves is called:', 'explanation' => 'Transpiration is the evaporation of water from plant leaves, mainly through stomata.', 'options' => [['A', 'Photosynthesis', false], ['B', 'Transpiration', true], ['C', 'Respiration', false], ['D', 'Germination', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'medium', 'question' => 'Which part of the flower produces pollen?', 'explanation' => 'The stamen, the male reproductive part of a flower, produces pollen.', 'options' => [['A', 'Pistil', false], ['B', 'Stamen', true], ['C', 'Sepal', false], ['D', 'Petal', false]]],
        ['subject' => 'biology', 'topic' => 'plant-biology', 'difficulty' => 'easy', 'question' => 'What is the process by which a seed develops into a new plant?', 'explanation' => 'Germination is the process by which a seed sprouts and develops into a seedling.', 'options' => [['A', 'Pollination', false], ['B', 'Germination', true], ['C', 'Fertilization', false], ['D', 'Propagation', false]]],

        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'Which scientist is credited with developing the germ theory of disease?', 'explanation' => 'Louis Pasteur\'s experiments established that microorganisms cause disease.', 'options' => [['A', 'Charles Darwin', false], ['B', 'Louis Pasteur', true], ['C', 'Gregor Mendel', false], ['D', 'Isaac Newton', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'Bacteria are classified as which type of organism?', 'explanation' => 'Bacteria are prokaryotes, lacking a membrane-bound nucleus.', 'options' => [['A', 'Eukaryotic', false], ['B', 'Prokaryotic', true], ['C', 'Multicellular', false], ['D', 'Viral', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'easy', 'question' => 'Which microorganisms are used to make yogurt and cheese?', 'explanation' => 'Beneficial bacteria ferment milk to produce yogurt and cheese.', 'options' => [['A', 'Viruses', false], ['B', 'Bacteria', true], ['C', 'Protozoa', false], ['D', 'Prions', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'Antibiotics are effective against which type of pathogen?', 'explanation' => 'Antibiotics target bacterial cell processes and are ineffective against viruses.', 'options' => [['A', 'Viruses', false], ['B', 'Bacteria', true], ['C', 'Prions', false], ['D', 'All pathogens equally', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'easy', 'question' => 'Which scientist discovered penicillin?', 'explanation' => 'Alexander Fleming discovered penicillin in 1928 from Penicillium mold.', 'options' => [['A', 'Alexander Fleming', true], ['B', 'Robert Koch', false], ['C', 'Edward Jenner', false], ['D', 'Joseph Lister', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'Viruses differ from bacteria mainly because viruses:', 'explanation' => 'Viruses are obligate parasites and require a host cell\'s machinery to reproduce.', 'options' => [['A', 'Are larger', false], ['B', 'Cannot reproduce without a host cell', true], ['C', 'Have a nucleus', false], ['D', 'Are always harmful', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'What is the process of using heat to kill harmful microorganisms in food called?', 'explanation' => 'Pasteurization uses controlled heat to destroy pathogens in food and beverages.', 'options' => [['A', 'Fermentation', false], ['B', 'Pasteurization', true], ['C', 'Sterilization', false], ['D', 'Distillation', false]]],
        ['subject' => 'biology', 'topic' => 'microbiology', 'difficulty' => 'medium', 'question' => 'Fungi obtain nutrients by:', 'explanation' => 'Fungi are heterotrophs that absorb nutrients from organic matter in their environment.', 'options' => [['A', 'Photosynthesis', false], ['B', 'Absorbing organic matter', true], ['C', 'Chemosynthesis', false], ['D', 'Filter feeding', false]]],
    ];

    $questions = array_merge(
        $questions,
        require __DIR__ . '/data/mcq_chemistry_physics.php',
        require __DIR__ . '/data/mcq_math_english.php',
        require __DIR__ . '/data/mcq_gk_cs.php',
        require __DIR__ . '/data/mcq_urdu_islamic.php'
    );

    $findSubject = $pdo->prepare('SELECT id FROM mcq_subjects WHERE slug = ?');
    $findTopic = $pdo->prepare('SELECT id FROM mcq_topics WHERE slug = ? AND subject_id = ?');
    $findExisting = $pdo->prepare('SELECT id FROM mcq_questions WHERE question_text = ? LIMIT 1');
    $insertMcq = $pdo->prepare(
        'INSERT INTO mcq_questions (subject_id, topic_id, question_text, explanation, difficulty, created_at, updated_at)
         VALUES (?, ?, ?, ?, ?, NOW(), NOW())'
    );
    $insertOption = $pdo->prepare(
        'INSERT INTO mcq_options (mcq_id, label, option_text, is_correct, sort_order) VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($questions as $q) {
        $findExisting->execute([$q['question']]);
        if ($findExisting->fetchColumn()) continue;

        $findSubject->execute([$q['subject']]);
        $subjectId = $findSubject->fetchColumn();
        if (!$subjectId) continue;

        $findTopic->execute([$q['topic'], $subjectId]);
        $topicId = $findTopic->fetchColumn() ?: null;

        $insertMcq->execute([$subjectId, $topicId, $q['question'], $q['explanation'], $q['difficulty']]);
        $mcqId = (int) $pdo->lastInsertId();

        foreach ($q['options'] as $order => $option) {
            [$label, $text, $isCorrect] = $option;
            $insertOption->execute([$mcqId, $label, $text, $isCorrect ? 1 : 0, $order]);
        }
    }
};

import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class RapportTravaux extends StatefulWidget {
  const RapportTravaux({super.key});

  @override
  State<RapportTravaux> createState() => _RapportTravauxState();
}

class _RapportTravauxState extends State<RapportTravaux> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color constructionOrange = const Color(0xFFE67E22);

  // Liste fictive des rapports déjà soumis
  final List<Map<String, dynamic>> rapports = [
    {"titre": "Terrassement Zone A", "date": "10/02/2026", "avancement": 100, "statut": "Validé"},
    {"titre": "Fondations Bâtiment B", "date": "12/02/2026", "avancement": 45, "statut": "En attente"},
  ];

  void _showAddRapportModal() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(20))),
      builder: (context) => const ModalSoumissionRapport(),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      appBar: AppBar(
        title: Text("Rapports de Chantier", style: GoogleFonts.montserrat(fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        foregroundColor: primaryBlue,
        elevation: 0,
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: _showAddRapportModal,
        backgroundColor: constructionOrange,
        child: const Icon(Icons.add_a_photo_rounded, color: Colors.white),
      ),
      body: Padding(
        padding: const EdgeInsets.all(20.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text("Suivi Physique", style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
            const SizedBox(height: 15),
            Expanded(
              child: ListView.builder(
                itemCount: rapports.length,
                itemBuilder: (context, index) => _buildRapportCard(rapports[index]),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildRapportCard(Map<String, dynamic> rapport) {
    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 5)],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(rapport['titre'], style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
              Text(rapport['date'], style: const TextStyle(color: Colors.grey, fontSize: 12)),
            ],
          ),
          const SizedBox(height: 10),
          Row(
            children: [
              Expanded(
                child: LinearProgressIndicator(
                  value: rapport['avancement'] / 100,
                  backgroundColor: Colors.grey[200],
                  color: constructionOrange,
                ),
              ),
              const SizedBox(width: 10),
              Text("${rapport['avancement']}%"),
            ],
          ),
          const SizedBox(height: 10),
          Text("Statut: ${rapport['statut']}", 
            style: TextStyle(color: rapport['statut'] == "Validé" ? Colors.green : Colors.orange, fontWeight: FontWeight.w500)),
        ],
      ),
    );
  }
}

// --- FENÊTRE MODALE DE SOUMISSION ---

class ModalSoumissionRapport extends StatefulWidget {
  const ModalSoumissionRapport({super.key});

  @override
  State<ModalSoumissionRapport> createState() => _ModalSoumissionRapportState();
}

class _ModalSoumissionRapportState extends State<ModalSoumissionRapport> {
  double _currentSliderValue = 0;
  final TextEditingController _descController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.only(
        bottom: MediaQuery.of(context).viewInsets.bottom + 20,
        top: 20, left: 20, right: 20,
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Nouveau Rapport Journalier", 
            style: GoogleFonts.montserrat(fontSize: 20, fontWeight: FontWeight.bold)),
          const SizedBox(height: 20),
          
          TextFormField(
            controller: _descController,
            maxLines: 3,
            decoration: const InputDecoration(
              labelText: "Description des travaux réalisés",
              border: OutlineInputBorder(),
              hintText: "Ex: Coulage de la dalle du premier étage...",
            ),
          ),
          const SizedBox(height: 20),
          
          Text("Avancement des travaux : ${_currentSliderValue.round()}%", 
            style: const TextStyle(fontWeight: FontWeight.bold)),
          Slider(
            value: _currentSliderValue,
            max: 100,
            divisions: 20,
            label: _currentSliderValue.round().toString(),
            activeColor: const Color(0xFFE67E22),
            onChanged: (double value) {
              setState(() => _currentSliderValue = value);
            },
          ),
          
          const SizedBox(height: 10),
          OutlinedButton.icon(
            onPressed: () {}, // Simuler ajout de photo
            icon: const Icon(Icons.camera_alt),
            label: const Text("Ajouter des photos du chantier"),
            style: OutlinedButton.styleFrom(minimumSize: const Size(double.infinity, 50)),
          ),
          
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () => Navigator.pop(context),
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF1B4F72),
              minimumSize: const Size(double.infinity, 55),
            ),
            child: const Text("ENVOYER POUR VALIDATION", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}
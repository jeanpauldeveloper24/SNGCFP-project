import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class SuiviTravaux extends StatelessWidget {
  const SuiviTravaux({super.key});

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color badGreen = const Color(0xFF2ECC71);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildProgressOverview(),
          const SizedBox(height: 30),
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Expanded(flex: 3, child: _buildJournalChantier()),
              const SizedBox(width: 20),
              Expanded(flex: 2, child: _buildMediaUploadZone()),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildProgressOverview() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        children: [
          _buildCircularProgress("Avancement Physique", 0.65, Colors.blue),
          _buildCircularProgress("Consommation Délai", 0.50, Colors.orange),
          _buildCircularProgress("Avancement Financier", 0.42, badGreen),
        ],
      ),
    );
  }

  Widget _buildCircularProgress(String title, double value, Color color) {
    return Column(
      children: [
        Stack(
          alignment: Alignment.center,
          children: [
            SizedBox(
              height: 80,
              width: 80,
              child: CircularProgressIndicator(
                value: value,
                strokeWidth: 8,
                backgroundColor: Colors.grey[200],
                valueColor: AlwaysStoppedAnimation<Color>(color),
              ),
            ),
            Text("${(value * 100).toInt()}%",
                style: const TextStyle(fontWeight: FontWeight.bold)),
          ],
        ),
        const SizedBox(height: 10),
        Text(title, style: const TextStyle(fontSize: 12, color: Colors.grey)),
      ],
    );
  }

  Widget _buildJournalChantier() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("Journal de Bord & Tâches",
            style: GoogleFonts.montserrat(
                fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
        const SizedBox(height: 15),
        _taskItem("Coulage des piles du pont (Axe Nord)", "En cours", 0.8),
        _taskItem("Terrassement zone accès Est", "Terminé", 1.0),
        _taskItem("Pose des armatures métalliques", "En attente", 0.0),
        _taskItem("Installation station de pompage", "Retardé", 0.15),
      ],
    );
  }

  Widget _taskItem(String title, String status, double progress) {
    return Container(
      margin: const EdgeInsets.only(bottom: 10),
      padding: const EdgeInsets.all(15),
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.black12)),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
              Text(status, style: TextStyle(fontSize: 11, color: _getStatusColor(status))),
            ],
          ),
          const SizedBox(height: 10),
          LinearProgressIndicator(
            value: progress,
            backgroundColor: Colors.grey[100],
            valueColor: AlwaysStoppedAnimation<Color>(_getStatusColor(status)),
          ),
        ],
      ),
    );
  }

  Widget _buildMediaUploadZone() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("Preuves Terrain (Photo/Vidéo)",
            style: GoogleFonts.montserrat(
                fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
        const SizedBox(height: 15),
        Container(
          padding: const EdgeInsets.all(25),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: primaryBlue, style: BorderStyle.solid),
          ),
          child: Column(
            children: [
              const Icon(Icons.add_a_photo_outlined, size: 40, color: Colors.grey),
              const SizedBox(height: 10),
              const Text("Uploader les photos d'avancement pour justifier les imports",
                  textAlign: TextAlign.center, style: TextStyle(fontSize: 12)),
              const SizedBox(height: 20),
              ElevatedButton(
                onPressed: () {},
                style: ElevatedButton.styleFrom(backgroundColor: primaryBlue),
                child: const Text("Prendre une photo", style: TextStyle(color: Colors.white)),
              ),
            ],
          ),
        ),
        const SizedBox(height: 15),
        // Aperçu des médias
        Wrap(
          spacing: 10,
          children: [
            _mediaPreview(Icons.image, "Pile_01.jpg"),
            _mediaPreview(Icons.video_collection, "Vue_Drone.mp4"),
          ],
        )
      ],
    );
  }

  Widget _mediaPreview(IconData icon, String label) {
    return Container(
      width: 100,
      padding: const EdgeInsets.all(8),
      decoration: BoxDecoration(color: Colors.grey[200], borderRadius: BorderRadius.circular(8)),
      child: Column(
        children: [
          Icon(icon, color: primaryBlue),
          const SizedBox(height: 5),
          Text(label, style: const TextStyle(fontSize: 10), overflow: TextOverflow.ellipsis),
        ],
      ),
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case "Terminé": return badGreen;
      case "En cours": return Colors.blue;
      case "Retardé": return Colors.red;
      default: return Colors.grey;
    }
  }
}
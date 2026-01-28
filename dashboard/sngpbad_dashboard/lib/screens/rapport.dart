import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Rapport extends StatelessWidget {
  const Rapport({super.key});

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Container(
        width: 600, // Format papier centré
        padding: const EdgeInsets.all(40),
        decoration: BoxDecoration(color: Colors.white, boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 20)]),
        child: Column(
          children: [
            // ENTÊTE OFFICIELLE
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  children: [
                    const Text("REPUBLIQUE DE COTE D'IVOIRE", style: TextStyle(fontSize: 10, fontWeight: FontWeight.bold)),
                    const Text("Union - Discipline - Travail", style: TextStyle(fontSize: 8, fontStyle: FontStyle.italic)),
                    const SizedBox(height: 5),
                    // Image de l'armoirie (Placeholder)
                    Container(height: 40, width: 40, color: Colors.grey[200], child: const Icon(Icons.account_balance, size: 20)),
                  ],
                ),
                // Logo BAD (Placeholder)
                Container(height: 50, width: 80, color: Colors.blue[50], child: const Center(child: Text("BAD", style: TextStyle(fontWeight: FontWeight.bold)))),
              ],
            ),
            const Divider(height: 40, thickness: 2),
            Text("RAPPORT D'AVANCEMENT PERIODIQUE", style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
            const SizedBox(height: 40),
            _buildReportField("Projet :", "Aménagement des routes rurales - Phase II"),
            _buildReportField("Période :", "Janvier 2026 - Mars 2026"),
            const Spacer(),
            ElevatedButton.icon(
              onPressed: () {},
              icon: const Icon(Icons.picture_as_pdf),
              label: const Text("Générer le PDF officiel"),
              style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF1B4F72), foregroundColor: Colors.white),
            )
          ],
        ),
      ),
    );
  }

  Widget _buildReportField(String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Row(
        children: [
          Text(label, style: const TextStyle(fontWeight: FontWeight.bold)),
          const SizedBox(width: 10),
          Text(value),
        ],
      ),
    );
  }
}
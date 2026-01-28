import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class SectorPerformance extends StatelessWidget {
  const SectorPerformance({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Analyse de l'Impact par Secteur",
            style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: const Color(0xFF1B4F72)),
          ),
          const SizedBox(height: 25),
          
          // Grille des secteurs
          GridView.count(
            shrinkWrap: true,
            crossAxisCount: 2,
            crossAxisSpacing: 20,
            mainAxisSpacing: 20,
            childAspectRatio: 1.5,
            children: [
              _buildSectorCard("Infrastructures", Icons.edit_road, "12 Projets", 0.75, Colors.blue),
              _buildSectorCard("Énergie", Icons.bolt, "8 Projets", 0.60, Colors.yellow[800]!),
              _buildSectorCard("Agriculture", Icons.agriculture, "15 Projets", 0.90, Colors.green),
              _buildSectorCard("Éducation", Icons.school, "5 Projets", 0.30, Colors.purple),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildSectorCard(String title, IconData icon, String count, double perf, Color color) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(icon, color: color, size: 30),
          const SizedBox(height: 10),
          Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
          Text(count, style: const TextStyle(color: Colors.grey, fontSize: 12)),
          const SizedBox(height: 10),
          LinearProgressIndicator(value: perf, color: color, backgroundColor: color.withOpacity(0.1)),
        ],
      ),
    );
  }
}
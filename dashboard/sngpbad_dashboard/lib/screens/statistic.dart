import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Statistic extends StatefulWidget {
  const Statistic({super.key});

  @override
  State<Statistic> createState() => _StatisticState();
}

class _StatisticState extends State<Statistic> {
  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Indicateurs de Performance (KPI)", 
            style: GoogleFonts.montserrat(fontSize: 22, fontWeight: FontWeight.bold, color: primaryBlue)),
          const SizedBox(height: 25),
          
          // Cartes KPI
          Row(
            children: [
              _buildCard("PROJETS", "32", Icons.folder, Colors.blue),
              _buildCard("BUDGET", "154 Mrd", Icons.payments, Colors.green),
              _buildCard("DÉCAISSEMENT", "45%", Icons.speed, Colors.orange),
              _buildCard("ALERTES", "04", Icons.report, Colors.red),
            ],
          ),
          
          const SizedBox(height: 40),
          Text("Détails des Projets", 
            style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
          const SizedBox(height: 15),
          
          // Tableau
          _buildTable(),
        ],
      ),
    );
  }

  Widget _buildCard(String title, String value, IconData icon, Color color) {
    return Expanded(
      child: Container(
        margin: const EdgeInsets.all(8),
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: Colors.black12),
        ),
        child: Column(
          children: [
            Icon(icon, color: color, size: 30),
            const SizedBox(height: 10),
            Text(value, style: GoogleFonts.montserrat(fontSize: 20, fontWeight: FontWeight.bold)),
            Text(title, style: GoogleFonts.inter(fontSize: 10, color: Colors.grey)),
          ],
        ),
      ),
    );
  }

  Widget _buildTable() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.black12)),
      child: DataTable(
        columns: const [
          DataColumn(label: Text("Projet")),
          DataColumn(label: Text("Budget")),
          DataColumn(label: Text("Statut")),
        ],
        rows: [
          _buildRow("Route Yamoussoukro", "45M", "En cours", Colors.blue),
          _buildRow("Énergie Nord", "12M", "Terminé", Colors.green),
          _buildRow("Agriculture Cacao", "28M", "Alerte", Colors.red),
        ],
      ),
    );
  }

  DataRow _buildRow(String t1, String t2, String t3, Color c) {
    return DataRow(cells: [
      DataCell(Text(t1)), DataCell(Text(t2)),
      DataCell(Text(t3, style: TextStyle(color: c, fontWeight: FontWeight.bold))),
    ]);
  }
}
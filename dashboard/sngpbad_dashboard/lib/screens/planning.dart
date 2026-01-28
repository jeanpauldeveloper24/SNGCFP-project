import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class Planning extends StatelessWidget {
  const Planning({super.key});

  final Color primaryBlue = const Color(0xFF1B4F72);
  final Color alertOrange = const Color(0xFFE67E22);

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(20),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildPlanningHeader(),
          const SizedBox(height: 25),
          Row(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Expanded(flex: 3, child: _buildGanttSimplified()),
              const SizedBox(width: 20),
              Expanded(flex: 2, child: _buildDelayJustification()),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildPlanningHeader() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.black12),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          _buildDateInfo("Date de début", "15 Janv. 2025", Icons.calendar_today),
          _buildDateInfo("Fin Prévisionnelle", "15 Janv. 2027", Icons.event_available),
          _buildDateInfo("Jours Restants", "356 Jours", Icons.timer_outlined),
        ],
      ),
    );
  }

  Widget _buildDateInfo(String label, String date, IconData icon) {
    return Row(
      children: [
        Icon(icon, color: primaryBlue, size: 20),
        const SizedBox(width: 10),
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(label, style: const TextStyle(fontSize: 11, color: Colors.grey)),
            Text(date, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 14)),
          ],
        )
      ],
    );
  }

  Widget _buildGanttSimplified() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text("Chronogramme des activités", 
            style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
        const SizedBox(height: 15),
        _buildGanttBar("Fondations & Radier", 1.0, "Terminé"),
        _buildGanttBar("Élévation des Piliers", 0.75, "En cours"),
        _buildGanttBar("Tablier Principal", 0.30, "Alerte Retard", isAlert: true),
        _buildGanttBar("Revêtement & Finitions", 0.0, "À venir"),
      ],
    );
  }

  Widget _buildGanttBar(String task, double progress, String label, {bool isAlert = false}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(task, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w500)),
              Text(label, style: TextStyle(fontSize: 11, color: isAlert ? Colors.red : Colors.grey)),
            ],
          ),
          const SizedBox(height: 8),
          Stack(
            children: [
              Container(height: 12, decoration: BoxDecoration(color: Colors.grey[200], borderRadius: BorderRadius.circular(10))),
              FractionallySizedBox(
                widthFactor: progress,
                child: Container(
                  height: 12, 
                  decoration: BoxDecoration(
                    color: isAlert ? Colors.red[400] : primaryBlue, 
                    borderRadius: BorderRadius.circular(10)
                  )
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildDelayJustification() {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: alertOrange.withOpacity(0.05),
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: alertOrange.withOpacity(0.3)),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Icon(Icons.warning_amber_rounded, color: alertOrange),
              const SizedBox(width: 10),
              Text("JUSTIFIER UN RETARD", style: TextStyle(fontWeight: FontWeight.bold, color: alertOrange)),
            ],
          ),
          const SizedBox(height: 15),
          const Text(
            "Si le retard est dû à l'attente d'une mainlevée ou à un cas de force majeure, soumettez votre demande ici.",
            style: TextStyle(fontSize: 12),
          ),
          const SizedBox(height: 15),
          TextField(
            maxLines: 3,
            decoration: InputDecoration(
              hintText: "Description du blocage...",
              fillColor: Colors.white,
              filled: true,
              border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
            ),
          ),
          const SizedBox(height: 15),
          ElevatedButton(
            onPressed: () {},
            style: ElevatedButton.styleFrom(backgroundColor: alertOrange, minimumSize: const Size(double.infinity, 45)),
            child: const Text("Envoyer la requête", style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}